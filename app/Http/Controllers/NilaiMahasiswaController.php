<?php

namespace App\Http\Controllers;

use App\Models\NilaiMahasiswa;
use App\Models\Kelompok;
use App\Models\PoinPenilaian;
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
    public function store(Request $request)
    {
        //
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
