<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

use App\Models\{
  Person,
  Registration
};
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
  public function search(Request $request)
  {

    $param = (int) $request->search;
    $identifier = "nik";

    if (!$person = Person::FindByNik($param)) {
      $person = Person::FindByKk($param);
      $identifier = "kk";
    }

    if (!$person) {
      return redirect()->route('register')
        ->with('warning', "NIK/KK {$param} tidak tercatat di database");
    }

    return redirect()->route('kk', $person->kk . "?nik=" . $person->nik);
    // if($identifier === 'nik') {
    //     return redirect()->route('nik', $person->nik);
    // } else {
    // }
  }

  public function kk_detail($kk)
  {
    $family_members = Person::with([
      'religion',
      'marital_status',
      'gender',
      'blood_type',
      'registrations' => function ($q) {
        $q->orderBy('infected_date_start', 'ASC');
      }
    ])->kk($kk)
      ->orderBy('nik', 'ASC')
      ->get();

    $assign['kk'] = (int) $kk;
    $assign['no'] = 1;
    $assign['family_members'] = $family_members;

    if (!$family_members->count()) {
      return view('detail.kk', $assign)
        ->with('warning', 'Belum ada pasien terdaftar dengan no KK ' . (int) $kk);
    }

    return view('detail.kk', $assign);
  }

  public function print($id)
  {
    $registration = Registration::find($id);

    if (!$registration) {
      die('Tidak ditemukan');
    }

    $patient = Person::find($registration->patient_id);

    $pdf = PDF::loadview('detail.print', ['patient' => $patient, 'registration' => $registration]);
    return $pdf->stream('pasien_' . $patient->nik . '_' . $patient->id . '_' . time() . '.pdf');
  }

  public function print_no_covid($id)
  {
    $patient = Person::find($id);

    if (!$patient) {
      die('Tidak ditemukan');
    }

    $pdf = PDF::loadview('detail.print_no_covid', ['patient' => $patient]);
    return $pdf->stream('pasien_' . $patient->nik . '_' . $patient->id . '_' . time() . '.pdf');
  }

  public function monitoring()
  {

    $people = DB::select(DB::raw("SELECT count(DISTINCT kk) as kk, count(id) as total FROM people"))[0];

    $covid_status = DB::select(DB::raw("SELECT
      SUM(CASE WHEN covid_status = 'been_infected' THEN 1 ELSE 0 END) as been_infected,
      SUM(CASE WHEN covid_status = 'being_infected' THEN 1 ELSE 0 END) as being_infected
    FROM people"))[0];

    $persons = Person::orderBy("first_name", "ASC")->get();

    return view("monitoring.index", compact([
      'people', 'covid_status', 'persons'
    ]));
  }
}
