<?php

namespace App\Http\Controllers;

use App\Models\NilaiMahasiswa;
use App\Models\DetailNilaiMahasiswa;
use App\Models\KomponenPenilaian;
use App\Models\Kelompok;
use App\Models\PoinPenilaian;
use App\Models\Mahasiswa;
use Auth;
use Illuminate\Http\Request;

class NilaiMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Kelompok $kelompok, PoinPenilaian $penilaian)
    {
        // return $penilaian;
        return view('dashboard.penilaian.detail',[
            'kelompok' => $kelompok,
            'penilaian' => $penilaian,
        ]);
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
    public function store(Request $request, Kelompok $kelompok, PoinPenilaian $penilaian, Mahasiswa $mahasiswa)
    {
        // return $request;
       $data = [];
       $komponen = $penilaian->komponen_penilaian;
       foreach($komponen as $pkp){
            $data['komponen'.$pkp->id] = 'required';
       }

       $validasi = $request->validate($data);
       $total = 0;
       foreach($komponen as $pkp){
            $total += $validasi['komponen'.$pkp->id] * ($pkp->bobot / 100);
       }

    //    return $kelompok->role_kelompok->where('nidn',Auth::user()->dosen->nidn);
    //    ->role_kelompok;
    $role = Auth::user()->dosen->role_kelompok($kelompok->id)->role_group;
    // return $bobot;
    // ->role_group->bobot;
       $nilai = new NilaiMahasiswa;
       $nilai->kelompok_id = $kelompok->id;
       $nilai->poin_penilaian_id = $penilaian->id;
       $nilai->role_dosen_kelompok_id = $role->id;
    //    Auth;
       $nilai->nim = $mahasiswa->nim;
       $nilai->nilai = $total * ($role->bobot / 100);
       $nilai->save();

       foreach($komponen as $pkp){
           $detail_nilai = new DetailNilaiMahasiswa;
           $detail_nilai->nilai_id = $nilai->id;
           $detail_nilai->komponen_id = $pkp->id;
           $detail_nilai->nilai = $validasi['komponen'.$pkp->id];
           $detail_nilai->save();
       }

       return back()->with('success','Nilai mahasiswa berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(NilaiMahasiswa $nilaiMahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiMahasiswa $nilaiMahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NilaiMahasiswa $nilaiMahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiMahasiswa $nilaiMahasiswa)
    {
        //
    }
}
