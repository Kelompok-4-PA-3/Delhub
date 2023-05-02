<?php

namespace App\Http\Controllers\API\Lecturer;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function index(Request $request){
        $dosen = Dosen::where('user_id', auth()->user()->id)->with('pembimbing_1', 'pembimbing_2')->first();
        // get kelompok bimbingan
        // merge data pembimbing 1 dan 2
        $kelompok_bimbingan = array_merge($dosen->pembimbing_1->toArray(), $dosen->pembimbing_2->toArray());
        return ResponseFormatter::success(
            $kelompok_bimbingan
        , 'Data pembimbing berhasil diambil');
    }
}
