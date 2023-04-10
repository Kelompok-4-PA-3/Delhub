<?php

namespace App\Services;

use App\Models\Request;
use App\Models\PembimbingPenguji;
use App\Models\Reference;
use Auth;

class CheckRole{

    public function is_pembimbing($kelompok){
        $dosen = Auth::user()->dosen->nidn;
        // return $dosen;
        $pembimbing = PembimbingPenguji::where('kelompok_id',$kelompok)->pluck('dosen_id');

        if (in_array($dosen,$pembimbing->toArray())) {
            return true;
        }
        return false;
    }

}

?>