<?php

namespace App\Http\Controllers;

use App\Models\NilaiMahasiswaRole;
use App\Models\Kelompok;
use App\Models\RoleKelompok;
use App\Models\RoleGroupKelompok;
use Illuminate\Http\Request;

class NilaiMahasiswaRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Kelompok $kelompok, RoleKelompok $role, RoleGroupKelompok $roleGroup)
    {
        return view('dashboard.penilaian.detail_role',[
            'kelompok' => $kelompok,
            'roleGroup' => $roleGroup,
            'role_dosen' => $role,
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
    public function show(NilaiMahasiswaRole $nilaiMahasiswaRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiMahasiswaRole $nilaiMahasiswaRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NilaiMahasiswaRole $nilaiMahasiswaRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiMahasiswaRole $nilaiMahasiswaRole)
    {
        //
    }
}
