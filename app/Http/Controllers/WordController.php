<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordController extends Controller
{
public function formFeedback (Request $request){
    $kelompok = $request->kelompok;
    $nama1 = $request->nama1;
    $nama2 = $request->nama2;
    $nama3 = $request->nama3;
    $nim1 = $request->nim1;
    $nim2 = $request->nim2;
    $nim3 = $request->nim3;
    $hari = $request->hari;
    $tanggal = $request->tanggal;
    $mulai = $request->mulai;
    $selesai = $request->selesai;
    $ketua = $request->ketua;
    $penguji1 = $request->penguji1;
    $penguji2 = $request->penguji2;

    // Creating the new document...
    $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('template_form/form_feedback.docx');

    //edit string
    $phpWord->setValues([
        'kelompok' => $kelompok,
        'nama1' => $nama1,
        'nama2' => $nama2,
        'nama3' => $nama3,
        'nim1' => $nim1,
        'nim2' => $nim2,
        'nim3' => $nim3,
        'hari' => $hari,
        'tanggal' => $tanggal,
        'mulai' => $mulai,
        'selesai' => $selesai,
        'ketua' => $ketua,
        'penguji1' => $penguji1,
        'penguji2' => $penguji2,
    ]);

    $phpWord->saveAs('template_dokumen/TA2-Feedback-1718-PSxx - solo.docx');

}
}
