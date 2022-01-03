<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\{
    Person,
    Gender,
    Religion,
    BloodType,
    MaritalStatus
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

        
        try {
            
            $input['date_of_birth'] = date('Y-m-d', strtotime($request->date_of_birth));
            $input['on_covid'] = @$request->on_covid == 'yes' ? true : false;
            
            $person = Person::create($input);

            return redirect()->route('kk', $person->kk)
                ->with('success', 'Pasien berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()->route('register')
                ->with('error', $e->getMessage())
                ->withInput($request->all())
                ->withErrors($valid->errors());
        }
    }
}
