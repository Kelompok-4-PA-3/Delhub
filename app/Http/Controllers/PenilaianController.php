<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\PoinPenilaian;

class PenilaianController extends Controller
{
    public function index(Krs $kr){
        return view('dashboard.penilaian.hasil_penilaian',[
            'krs' => $kr
        ]);
    }

    public function detail_hasil_nilai(Krs $kr, PoinPenilaian $penilaian){
        // return $penilaian;
        return view('dashboard.penilaian.hasil_penilaian_detail',[
            'krs' => $kr,
            'penilaian' => $penilaian
        ]);
    }
}
