<?php

namespace App\Services;

use App\Models\Request;
use App\Models\PembimbingPenguji;
use App\Models\Reference;
use App\Models\KelompokMahasiswa;
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

}

?>