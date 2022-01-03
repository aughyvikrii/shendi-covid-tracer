<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    Person
};

class MainController extends Controller
{
    public function search (Request $request) {

        $param = (int) $request->search;
        $identifier = "nik";

        if(!$person = Person::FindByNik($param)) {
            $person = Person::FindByKk($param);
            $identifier = "kk";
        }

        if(!$person) {
            return redirect()->route('register')
                ->with('warning', "NIK/KK {$param} tidak tercatat di database");
        }
        
        return redirect()->route('kk', $person->kk . "?nik=" . $person->nik);
        // if($identifier === 'nik') {
        //     return redirect()->route('nik', $person->nik);
        // } else {
        // }
    }

    public function kk_detail($kk) {
        $family_members = Person::with([
            'religion', 'marital_status', 'gender', 'blood_type'
        ])->kk($kk)
        ->get();

        $assign['kk'] = (int) $kk;
        $assign['family_members'] = $family_members;

        if(!$family_members->count()) {
            return view('detail.kk', $assign)
                ->with('warning', 'Belum ada pasien terdaftar dengan no KK ' . (int) $kk);
        }

        return view('detail.kk', $assign);
    }
}
