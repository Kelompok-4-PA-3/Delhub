<?php

namespace App\Http\Controllers\API;

use App\Models\Dosen;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class LectureController extends Controller
{
    public function getCourses(){
        // get dosen where user_id is auth()->user()->id
        $dosen = Dosen::where('user_id', auth()->user()->id)->first();
        dd($dosen->krs);
    }
    public function getGuidance(Request $request){
        // get kelompok where krs_id is $request->krs_id and pembimbing 1 or pembimbing 2 is auth()->user()->id
        $dosen = Dosen::where('user_id', auth()->user()->id)->first();
        $kelompoks = Kelompok::where('krs_id', $request->krs_id)->whereHas('pembimbings', function ($query) use ($dosen) {
            $query->where('pembimbing_1', $dosen->nidn)->orWhere('pembimbing_2', $dosen->nidn);
        })->get();
        return ResponseFormatter::success($kelompoks, 'Data berhasil diambil');
    }
}
