<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use App\Models\Pembimbing;
use Auth;
use Illuminate\Support\Facades\Gate;


class MyProjectController extends Controller
{
    public function koordinator($id){
        
        $krs = Krs::where('id',$id)->first();

        if (Auth::user()->hasRole('admin')) {
          
        }else{
            if(Auth::user()->hasRole('dosen') && $krs != NULL){
                if (!Gate::check('krs_owner', $krs)) {
                    return back();
                }
            }else{
                return back();
            }
        }
        

        $kelompok = Kelompok::where('krs_id','=', $krs->id)->get();
        $mahasiswa = Mahasiswa::latest()->get();
        // return $krs->count();
        if ($krs->count() > 0) {
            return view('dashboard.koordinator',[
                'title' =>  $krs->kategori->nama_mk,
                'krs' => $krs,
                'kelompok' => $kelompok,
                'mahasiswa' => $mahasiswa
            ]);
        }
        return back();
    }

    public function koordintor_job_list(){
        $krs = Krs::where('dosen_mk','=', Auth::user()->dosen->nidn)->orWhere('dosen_mk_2','=', Auth::user()->dosen->nidn)->get();
        // $kelompok = Kelompok::where('krs_id','=', $krs->id)->get();
        // $mahasiswa = Mahasiswa::latest()->get();
        // return $krs->count();
        if ($krs->count() > 0) {
            return view('dashboard.koordinator_krs',[
                'title' =>  'Koordinator - My Project',
                'krs' => $krs,
                // 'kelompok' => $kelompok,
                // 'mahasiswa' => $mahasiswa
            ]);
        }
        return back();
    }

    public function pembimbing($nidn){
        // return $nidn;
        $kelompok = Pembimbing::where('pembimbing_1','=', $nidn)
                    ->orWhere('pembimbing_2',$nidn)
                    ->join('kelompoks','kelompoks.id','=','pembimbings.kelompok_id')
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
