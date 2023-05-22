<?php

namespace App\Http\Controllers;

use App\Models\RoleKelompok;
use App\Models\RoleGroupKelompok;
use App\Models\KategoriRole;
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
    public function verification(Request $request, Kelompok $kelompok)
    {   
        $check = true;
        $all_role = RoleGroupKelompok::join('kategori_roles', 'role_group_kelompoks.kategori_id', 'kategori_roles.id')
                                    ->where('kategori_roles.krs_id',$kelompok->krs_id)
                                    ->select('role_group_kelompoks.*')
                                    ->get();

        foreach ($all_role  as $ar) {
            if ($ar->role_kelompok->where('kelompok_id', $kelompok->id)->count() <= 0 && $ar->is_main) {
                return back()->with('failed', 'Terdapat beberapa role wajib yang belum diassign');
            }
        }
        
        $status = true;
        if ($request->status == 'not_verified') {
            $status = false;
        }
        RoleKelompok::where('kelompok_id',$kelompok->id)->update([
            'is_verified' => $status
        ]);

        return back()->with('success', 'Verifikasi role dosen telah berhasil');
    }

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
