<?php

namespace App\Exports;

use App\Models\Krs;
use App\Models\PoinPenilaian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailNilaiExportView implements FromView
{
   protected $kr;
    protected $penilaian;

    public function __construct(Krs $kr, PoinPenilaian $penilaian)
    {
        $this->kr = $kr;
        $this->penilaian = $penilaian;
    }

    public function view(): View
    {
        return view('dashboard.penilaian.table_detail_nilai_format', [
            'krs' => $this->kr,
            'penilaian' => $this->penilaian,
        ]);
    }
}
