<?php

namespace App\Http\Controllers;

use App\Models\KomponenPenilaian;
use App\Models\PoinPenilaian;
use App\Models\Krs;
use Illuminate\Http\Request;

class KomponenPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Krs $kr,PoinPenilaian $poinPenilaian)
    {
        // $komponen = KomponenPenilaian::where('poin_regulasi_id', $poinRegulasi->id)->get();
        // return view('poin_regulasi.komponen_penilaian.index', [
        //     'title' => $poinRegulasi->nama,
        //     'poin_regulasi' => $poinRegulasi,
        //     'komponen' => $komponen
        // ]);
        $komponen_penilaian = KomponenPenilaian::where('poin_penilaian_id', $poinPenilaian->id)->get();
        return view('dashboard.poinpenilaian.komponen_penilaian.index',[
            'komponen_penilaian' => $komponen_penilaian,
            'title' => $poinPenilaian->nama_poin,
            'krs' => $kr,
            'poin_penilaian' => $poinPenilaian,
        ]);
    }

    public function verifikasi_komponen_penilaian(Krs $kr,PoinPenilaian $poinPenilaian){
        $komponen = KomponenPenilaian::where('poin_penilaian_id', $poinPenilaian->id);
        // return $komponen->get();
        if($komponen->sum('bobot') != 100){
            return  back()->with('failed','Sepertinya jumlah bobot tidak mencapai 100% atau melebihinya, pastikan jumlah keseluruhan bobot mencapai tepat 100%');
        }

        $komponen->where('is_verified',false)->update([
            'is_verified' => true,
        ]);

        return back()->with('success','Verifikasi komponen penilaian telah berhasil');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Krs $kr,PoinPenilaian $poinPenilaian)
    {
        $data = [
            'nama_komponen' => 'required',
            'bobot' => 'required|numeric'
        ];

        $validasi = $request->validate($data);
        $validasi['poin_penilaian_id'] = $poinPenilaian->id;

        KomponenPenilaian::create($validasi);
        return back()->with('success','Komponen penilai telah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KomponenPenilaian $komponenPenilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomponenPenilaian $komponenPenilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $kr, PoinPenilaian $poinPenilaian, KomponenPenilaian $komponenPenilaian)
    {
        // return $poinRegulasi.$komponenPenilaian;
        // return $komponenPenilaian;
        $data = [
            'nama_komponen' => 'required',
            'bobot' => 'required|numeric'
        ];

        $validasi = $request->validate($data);
        $komponen = KomponenPenilaian::find($komponenPenilaian->id);
        $komponen->nama_komponen = $validasi['nama_komponen'];
        $komponen->bobot = $validasi['bobot'];
        $komponen->is_verified = false;
        $komponen->save();
        return back()->with('success','Komponen penilai telah berhasil ditambahkan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Krs $kr, PoinPenilaian $poinPenilaian, KomponenPenilaian $komponenPenilaian)
    {
        // return $komponenPenilaian;
        $komponen = KomponenPenilaian::where('id',$komponenPenilaian->id)->delete();
        // return $komponen;
        // ->delete();
        $komponen_all = KomponenPenilaian::where('poin_penilaian_id', $poinPenilaian->id);
        if($komponen_all->sum('bobot') != 100){
            $komponen_all->update([
                'is_verified' => false,
            ]);
        }
        return back()->with('success','Komponen penilaian telah berhasil dihapus');

    }
}
