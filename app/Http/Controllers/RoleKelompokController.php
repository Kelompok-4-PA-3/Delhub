<?php

namespace App\Http\Controllers;

use App\Models\RoleKelompok;
use App\Models\RoleGroupKelompok;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class RoleKelompokController extends Controller
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
    public function store(Request $request, Kelompok $kelompok, RoleGroupKelompok $roleGroupKelompok)
    {
        // return $request;
        $data = [   
            'nidn' => 'required',
            'role_group_id' => 'required'
        ];

        $validasi = $request->validate($data);
        $role = new RoleKelompok;
        $role->nidn = $validasi['nidn'];
        $role->role_group_id = $validasi['role_group_id'];
        $role->kelompok_id = $kelompok->id;
        $role->save();

        return back()->with('success', 'Data role telah berhasil dibuat');

        // return $kelompok.$roleGroupKelompok;
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleKelompok $roleKelompok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleKelompok $roleKelompok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleKelompok $roleKelompok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Kelompok $kelompok, RoleKelompok $roleKelompok)
    {
        $role = RoleKelompok::where('id', $roleKelompok->id)->delete();
        return back()->with('success', 'Data role dosen telah berhasil dihapus');
    }
}
