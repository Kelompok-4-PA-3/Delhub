<?php

namespace App\Services;

use App\Models\Request;
use App\Models\PembimbingPenguji;
use App\Models\Reference;
use App\Models\KelompokMahasiswa;
use App\Models\Kelompok;
use Auth;

class CheckRole{

    public function is_pembimbing($kelompok){
        $dosen = Auth::user()->dosen->nidn;
        $pembimbing = PembimbingPenguji::where('kelompok_id',$kelompok)->pluck('dosen_id');

        if (in_array($dosen,$pembimbing->toArray())) {
            return true;
        }
        return false;
    }

    public function is_kelompok_leader($kelompok){

        $mahasiswa = Auth::user()->mahasiswa;
        if($mahasiswa != NULL){
            $mahasiswa = $mahasiswa->nim;
            $role = Reference::where('kategori', 'role_kelompok')->where('value', 'leader')->first();
            $leader = KelompokMahasiswa::where('kelompok_id',$kelompok)->where('role',$role->id)->pluck('nim');
            // return $mahasiswa->nim;
            if(in_array($mahasiswa, $leader->toArray())){
                return true;
            }else{
                return  false;
            }

        }
        
        return 'mantappu';
                    
    }

    public function role_penilaian(Kelompok $kelompok){
        $pembimbing = $kelompok->pembimbings;
        // dd($pembimbing);
        $penguji = $kelompok->penguji;
        $dosen = Auth::user()->dosen->nidn;
        if ($dosen == $pembimbing->pembimbing_1) {
            return 'pembimbing_1';
        }elseif($dosen == $pembimbing->pembimbing_2){
            return 'pembimbing_2';
        }elseif($dosen == $penguji->penguji_1){
            return 'penguji_1';
        }elseif($dosen == $penguji->penguji_2){
            return 'penguji_2';
        }

        return 'not found';
    }

}

?>