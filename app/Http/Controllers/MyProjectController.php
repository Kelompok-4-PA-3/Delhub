<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use App\Models\PembimbingPenguji;
use Auth;

class MyProjectController extends Controller
{
    public function koordintor(){
        $krs = Krs::where('dosen_mk','=', Auth::user()->dosen->nidn)->first();
        $kelompok = Kelompok::where('krs_id','=', $krs->id)->get();
        $mahasiswa = Mahasiswa::latest()->get();
        // return $krs->count();
        if ($krs->count() > 0) {
            return view('dashboard.koordinator',[
                'title' =>  $krs->kategori->nama_singkat,
                'krs' => $krs,
                'kelompok' => $kelompok,
                'mahasiswa' => $mahasiswa
            ]);
        }
        return back();
    }

    public function pembimbing($nidn){
        // return $nidn;
        $kelompok = PembimbingPenguji::where('dosen_id','=', $nidn)
                    ->join('kelompoks','kelompoks.id','=','pembimbing_pengujis.kelompok_id')
                    // ->select('nama_kelompok')
                    ->get();
        // return $kelompok;

        return view('dashboard.pembimbing',[
            'title' =>  'Bimbingan Saya',
            // 'krs' => $krs,
            'kelompok' => $kelompok,
            // 'mahasiswa' => $mahasiswa
        ]);
    }
}
