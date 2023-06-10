<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\KelompokMahasiswa;

class WordController extends Controller
{
public function formFeedback (Request $request){

        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('template_form/template-form-control.docx');

        $phpWord->saveAs('template_dokumen/form_control_kelompok.docx');
        
    }

    public function form_control_bimbingan(Request $request, Kelompok $kelompok){
        // $rowIndex = 1;
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('template_form/template-form-control.docx');
        
        $anggota_kelompok =  KelompokMahasiswa::where('kelompok_id', $kelompok->id)
        ->join('mahasiswas', 'kelompok_mahasiswas.nim', 'mahasiswas.nim') 
        ->join('users', 'mahasiswas.user_id', 'users.id')->select('mahasiswas.nim', 'users.nama')->get(); 
        // return $anggota_kelompok;
        $phpWord->cloneRow('nama', count($anggota_kelompok));


        foreach ($anggota_kelompok as $index => $row) {
            $phpWord->setValue("nama#" . ($index + 1), $row['nama']);
            $phpWord->setValue("nim#" . ($index + 1), $row['nim']);
        }

        $phpWord->setValues([
            'judul' => $kelompok->topik,
            'kelompok' => $kelompok->nama_kelompok,
        ]);

        $phpWord->saveAs('template_export/form_control_'.$kelompok->nama_kelompok.'.docx');

    }
}
