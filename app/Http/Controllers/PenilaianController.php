<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;

class PenilaianController extends Controller
{
    public function index(Krs $kr){
        return view('dashboard.penilaian.hasil_penilaian',[
            'krs' => $kr
        ]);
    }
}
