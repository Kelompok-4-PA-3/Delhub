<?php

namespace App\Services;

use App\Models\Request;
use App\Models\PembimbingPenguji;
use App\Models\Reference;

class RequestBimbingan{

    public function bimbingan($dosen){

        $waiting =  Reference::where('kategori', 'status_bimbingan_default')->first()->id;
        $role = Reference::where('kategori', 'role_dosen')->where('value','pembimbing')->first();
        $pembimbing = PembimbingPenguji::where('dosen_id', $dosen)
                        ->where('reference_id', $role->id)
                        ->join('kelompoks', function($kelompok){
                            $kelompok->on('pembimbing_pengujis.kelompok_id','kelompoks.id')
                                    ->join('requests','kelompoks.id', 'requests.kelompok_id');
                                    // ->where('requests.referenceid', $waiting->id);
                        })->get();

        return compact('waiting', 'pembimbing');
        
    }

}

?>