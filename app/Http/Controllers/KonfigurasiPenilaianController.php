<?php

namespace App\Http\Controllers;

use App\Models\ConfigPenilaian;
use Illuminate\Http\Request;

class KonfigurasiPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        // return $request;a
        $data = [
            'pembimbing_1' => 'required',
            'pembimbing_2' => 'required',
            'penguji_1' => 'required',
            'penguji_2' => 'required',
            'krs_id' => 'required',
        ];

        $validasi = $request->validate($data);
        $total = $validasi['pembimbing_1'] + $validasi['pembimbing_2'] + $validasi['penguji_1'] + $validasi['penguji_2'];
        // return $total;
        $konfigurasi =  ConfigPenilaian::where('krs_id',$request->krs_id)->first();
        if ($total == 100) {
            if ($konfigurasi == NULL) {
                $konfigurasi = new ConfigPenilaian;
                ConfigPenilaian::create($validasi);
                return back()->with('success', 'Konfigurasi peilaian telah berhasil dibuat');
            }
            
            $konfigurasi->krs_id = $validasi['krs_id'];
            $konfigurasi->pembimbing_1 = $validasi['pembimbing_1'];
            $konfigurasi->pembimbing_2 = $validasi['pembimbing_2'];
            $konfigurasi->penguji_1 = $validasi['penguji_1'];
            $konfigurasi->penguji_2 = $validasi['penguji_2'];
            $konfigurasi->save();

            // ConfigPenilaian::create($validasi);
            return back()->with('success', 'Konfigurasi peilaian telah berhasil dibuat');

        }

        return back()->with('failed', 'Jumlah akumulasi bobot penilaian tidak mencapai 100% atau melebihinya, pastikan total bobot berjumlah tepat 100%');

    }

    /**
     * Display the specified resource.
     */
    public function show(ConfigPenilaian $configPenilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfigPenilaian $configPenilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConfigPenilaian $configPenilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConfigPenilaian $configPenilaian)
    {
        //
    }
}
