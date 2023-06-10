<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\PoinPenilaian;
use App\Exports\DetailNilaiExportView;
use Maatwebsite\Excel\Facades\Excel;


class PenilaianController extends Controller
{
    public function index(Request $request, Krs $kr){
        $pembimbing_kelompok = NULL;
        if ($request->kelompok){
            $pembimbing_kelompok = $request->kelompok;
        }

        return view('dashboard.penilaian.hasil_penilaian',[
            'krs' => $kr,
            'pembimbing_kelompok' => $pembimbing_kelompok
        ]);
    }

    public function detail_hasil_nilai(Request $request, Krs $kr, PoinPenilaian $penilaian){
        $pembimbing_kelompok = NULL;
        if ($request->kelompok){
            $pembimbing_kelompok = $request->kelompok;
        }
        return view('dashboard.penilaian.hasil_penilaian_detail',[
            'krs' => $kr,
            'penilaian' => $penilaian,
            'pembimbing_kelompok' => $pembimbing_kelompok
        ]);
    }

        public function export_excel_nilai(Krs $kr, PoinPenilaian $penilaian){

            // return view('dashboard.penilaian.table_detail_nilai_format', [
            //     'krs' => $kr,
            //     'penilaian' => $penilaian
            // ]);
            // return DetailNilaiExportView::view($kr,$penilaian);
            return Excel::download(new DetailNilaiExportView($kr,$penilaian), 'detail_nilai.xlsx');
        }

}
