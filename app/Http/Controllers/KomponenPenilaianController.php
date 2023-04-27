<?php

namespace App\Http\Controllers;

use App\Models\KomponenPenilaian;
use App\Models\PoinRegulasi;
use Illuminate\Http\Request;

class KomponenPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PoinRegulasi $poinRegulasi)
    {
        $komponen = KomponenPenilaian::where('poin_regulasi_id', $poinRegulasi->id)->get();
        // return $komponen;
        // return $poinRegulasi;
        return view('poin_regulasi.komponen_penilaian.index', [
            'title' => $poinRegulasi->nama,
            'poin_regulasi' => $poinRegulasi,
            'komponen' => $komponen
        ]);
    }

    public function verifikasi_komponen_penilaian(PoinRegulasi $poinRegulasi){
        $komponen = KomponenPenilaian::where('poin_regulasi_id', $poinRegulasi->id);
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
    public function store(Request $request, PoinRegulasi $poinRegulasi)
    {
        $data = [
            'komponen_penilaian' => 'required',
            'bobot' => 'required|numeric'
        ];

        $validasi = $request->validate($data);
        $validasi['poin_regulasi_id'] = $poinRegulasi->id;
        // return $validasi['poin_regulasi'];

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
    public function update(Request $request,PoinRegulasi $poinRegulasi ,KomponenPenilaian $komponenPenilaian)
    {
        // return $poinRegulasi.$komponenPenilaian;
        $data = [
            'komponen_penilaian' => 'required',
            'bobot' => 'required|numeric'
        ];

        $validasi = $request->validate($data);
        $validasi['poin_regulasi_id'] = $poinRegulasi->id;
        $komponen = KomponenPenilaian::find($komponenPenilaian->id);
        // return $komponen;
        $komponen->komponen_penilaian = $validasi['komponen_penilaian'];
        $komponen->bobot = $validasi['bobot'];
        $komponen->is_verified = false;
        $komponen->save();
        return back()->with('success','Komponen penilai telah berhasil ditambahkan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(PoinRegulasi $poinRegulasi ,KomponenPenilaian $komponenPenilaian)
    {
        $komponen = KomponenPenilaian::where('id',$komponenPenilaian->id)->delete();
        $komponen_all = KomponenPenilaian::where('poin_regulasi_id', $poinRegulasi->id);
        if($komponen_all->sum('bobot') != 100){
            $komponen_all->update([
                'is_verified' => false,
            ]);
        }
        return back()->with('success','Komponen penilai telah berhasil dihapus');

    }
}
