<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;

use App\Models\{
    Person,
    Gender,
    Religion,
    BloodType,
    MaritalStatus,
    Registration
};

class RegisterController extends Controller
{
    public function view() {

        $assign = [
            'marital_statuses' => MaritalStatus::orderBy('name')->get(),
            'genders' => Gender::orderBy('name')->get(),
            'religions' => Religion::orderBy('name')->get(),
            'blood_types' => BloodType::orderBy('name')->get(),
        ];

        return view('register.form', $assign);
    }

    public function action(Request $request) {

        $valid = Validator::make($request->all(), [
            'kk' => 'required|numeric|digits:16',
            'nik' => 'required|numeric|digits:16',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required|date',
            'address' => 'required',
            'religion_id' => 'required|exists:religions,id',
            'marital_status_id' => 'required|exists:marital_statuses,id',
            'gender_id' => 'required|exists:genders,id',
            'blood_type_id' => 'required|exists:blood_types,id',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
        ], [
            'required' => 'Data harus diisi',
            'numeric' => 'Isian berupa angka',
            'exists' => 'Data tidak valid',
        ]);

        if($valid->fails()) {
            return redirect()->route('register')
                ->with('error', 'Input tidak valid')
                ->withInput($request->all())
                ->withErrors($valid->errors());
        }

        $input = $valid->validated();

        DB::BeginTransaction();
        
        try {

            $covid_status = $request->input('covid_status', 'never_infected');
            $covid_status = in_array($covid_status, ['never_infected', 'being_infected', 'been_infected']) ? $covid_status : 'never_infected';

            $valid_extend_input = false;
            if($covid_status === 'being_infected') {
                $valid = Validator::make($request->all(), [
                    'infected_date_start' => 'required|date',
                    'covid_infected_start' => 'required|image|mimes:jpeg,png,jpg,gif'
                ]);

                $valid_extend_input = true;
            }
            else if ($covid_status === 'been_infected') {
                $valid = Validator::make($request->all(), [
                    'infected_date_start' => 'required|date',
                    'covid_infected_start' => 'required|image|mimes:jpeg,png,jpg,gif',
                    'infected_date_end' => 'required|date',
                    'covid_infected_end' => 'required|image|mimes:jpeg,png,jpg,gif',
                ]);

                $valid_extend_input = true;
            }

            if($valid_extend_input && $valid->fails()) {
                return redirect()->route('register')
                    ->with('error', 'Input tidak valid')
                    ->withInput($request->all())
                    ->withErrors($valid->errors());
            }

            $input['covid_status'] = $covid_status;
            $input['date_of_birth'] = date('Y-m-d', strtotime($request->date_of_birth));

            $person = Person::create($input);

            if ($valid_extend_input) {

                $register_data = [
                    'patient_id' => $person->id,
                ];

                if($covid_status === 'being_infected') {
                    $register_data['infected_date_start'] = date('Y-m-d', strtotime($request->input('infected_date_start', date('Y-m-d'))));

                    if(!$covid_infected_start = upload_file('covid_infected_start', $request)) {
                        DB::Rollback();
                        return redirect()->route('register')
                            ->with('error', 'Gagal upload bukti covid')
                            ->withInput($request->all())
                            ->withErrors($valid->errors());
                    }

                    $register_data['covid_infected_start'] = $covid_infected_start;
                }
                else if ($covid_status === 'been_infected') {
                    $register_data['infected_date_start'] = date('Y-m-d', strtotime($request->input('infected_date_start', date('Y-m-d'))));
                    $register_data['infected_date_end'] = date('Y-m-d', strtotime($request->input('infected_date_end', date('Y-m-d'))));

                    if(!$covid_infected_start = upload_file('covid_infected_start', $request)) {
                        DB::Rollback();
                        return redirect()->route('register')
                            ->with('error', 'Gagal upload bukti covid')
                            ->withInput($request->all())
                            ->withErrors($valid->errors());
                    }

                    $register_data['covid_infected_start'] = $covid_infected_start;

                    if(!$covid_infected_end = upload_file('covid_infected_end', $request)) {
                        DB::Rollback();
                        return redirect()->route('register')
                            ->with('error', 'Gagal upload bukti covid')
                            ->withInput($request->all())
                            ->withErrors($valid->errors());
                    }

                    $register_data['covid_infected_end'] = $covid_infected_end;
                }

                Registration::create($register_data);
            }

            DB::Commit();

            return redirect()->route('kk', $person->kk)
                ->with('success', 'Pasien berhasil ditambahkan');

        } catch (\Exception $e) {

            DB::Rollback();

            return redirect()->route('register')
                ->with('error', $e->getMessage())
                ->withInput($request->all())
                ->withErrors($valid->errors());
        }
    }

    public function update_covid_status ($id, Request $request) {
        try {

            $registration = Registration::find($id);

            $input['infection_status'] = 'healed';
            $input['infected_date_end'] = date('Y-m-d', strtotime($request->input('infected_date_end', date('Y-m-d'))));

            if(!$covid_infected_end = upload_file('covid_infected_end', $request)) {
                return redirect()->back()
                    ->with('error', 'Gagal upload bukti covid')
                    ->withInput($request->all());
            }

            $input['covid_infected_end'] = $covid_infected_end;

            $registration->update($input);


            $registration->patient->update([
                'covid_status' => 'been_infected',
            ]);

            return redirect()->back()
                ->with('success', 'Berhasil update status covid')
                ->withInput($request->all());
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput($request->all());
        }
    }

    public function register_patient(Request $request) {
        $patient = Person::find($request->patient_id);
        
        if(!$patient) {
            return redirect()->back()
                ->with('warning', "NIK/KK {$param} tidak tercatat di database");
        }

        $covid_status = $request->input('covid_status', 'never_infected');
        $covid_status = in_array($covid_status, ['never_infected', 'being_infected', 'been_infected']) ? $covid_status : 'never_infected';

        $valid_extend_input = false;
        if($covid_status === 'being_infected') {
            $valid = Validator::make($request->all(), [
                'infected_date_start' => 'required|date',
                'covid_infected_start' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]);

            $valid_extend_input = true;
        }
        else if ($covid_status === 'been_infected') {
            $valid = Validator::make($request->all(), [
                'infected_date_start' => 'required|date',
                'covid_infected_start' => 'required|image|mimes:jpeg,png,jpg,gif',
                'infected_date_end' => 'required|date',
                'covid_infected_end' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            $valid_extend_input = true;
        }

        if($valid_extend_input && $valid->fails()) {
                return redirect()->back()
                    ->with('error', 'Input tidak valid')
                    ->withInput($request->all())
                    ->withErrors($valid->errors());
        }

        if ($valid_extend_input) {

            $register_data = [
                'patient_id' => $patient->id,
            ];

            if($covid_status === 'being_infected') {
                $register_data['infected_date_start'] = date('Y-m-d', strtotime($request->input('infected_date_start', date('Y-m-d'))));

                if(!$covid_infected_start = upload_file('covid_infected_start', $request)) {
                    DB::Rollback();
                    return redirect()->back()
                        ->with('error', 'Gagal upload bukti covid')
                        ->withInput($request->all())
                        ->withErrors($valid->errors());
                }

                $register_data['covid_infected_start'] = $covid_infected_start;
            }
            else if ($covid_status === 'been_infected') {
                $register_data['infected_date_start'] = date('Y-m-d', strtotime($request->input('infected_date_start', date('Y-m-d'))));
                $register_data['infected_date_end'] = date('Y-m-d', strtotime($request->input('infected_date_end', date('Y-m-d'))));

                if(!$covid_infected_start = upload_file('covid_infected_start', $request)) {
                    DB::Rollback();
                    return redirect()->back()
                        ->with('error', 'Gagal upload bukti covid')
                        ->withInput($request->all())
                        ->withErrors($valid->errors());
                }

                $register_data['covid_infected_start'] = $covid_infected_start;

                if(!$covid_infected_end = upload_file('covid_infected_end', $request)) {
                    DB::Rollback();
                    return redirect()->back()
                        ->with('error', 'Gagal upload bukti covid')
                        ->withInput($request->all())
                        ->withErrors($valid->errors());
                }

                $register_data['covid_infected_end'] = $covid_infected_end;
            }

            Registration::create($register_data);

            $patient->update([
                'covid_status' => $covid_status
            ]);

            return redirect()->back()
                ->with('success', 'Berhasil menambah data');
        }
    }
}
