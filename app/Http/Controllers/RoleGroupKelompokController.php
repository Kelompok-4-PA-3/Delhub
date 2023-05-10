<?php

namespace App\Http\Controllers;

use App\Models\RoleGroupKelompok;
use App\Models\Krs;
use Illuminate\Http\Request;

class RoleGroupKelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Krs $kr)
    {
        // return $kr;
        $role_group = RoleGroupKelompok::where('krs_id',$kr->id)->get();
        // return $kr;
        // return $role_group;
        return view('dashboard.rolegroup.index',[
            'role_group' => $role_group,
            'krs' => $kr
        ]);
    }

    public function verifikasi_role_group(Krs $kr)
    {
        $role_group_all =RoleGroupKelompok::where('krs_id', $kr->id);
        if($role_group_all->sum('bobot') != 100){
            return  back()->with('failed','Sepertinya jumlah bobot tidak mencapai 100% atau melebihinya, pastikan jumlah keseluruhan bobot mencapai tepat 100%');
        }

        $role_group_all->where('is_verified',false)->update([
            'is_verified' => true,
        ]);

        return back()->with('success','Verifikasi bobot role telah berhasil');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Krs $kr)
    {
       $data = [
            'nama' => 'required',
            'bobot' => 'required',
       ];
       $validasi = $request->validate($data);
       $validasi['krs_id'] = $kr->id;
       RoleGroupKelompok::create($validasi);

       return back()->with('success', 'Data role group berhasil ditambahkan');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Krs $kr, RoleGroupKelompok $roleGroupKelompok)
    {
        $data = [
            'nama' => 'required',
            'bobot' => 'required',
       ];
       $validasi = $request->validate($data);
       $validasi['krs_id'] = $kr->id;
       $role_group = RoleGroupKelompok::find($roleGroupKelompok->id);
       $role_group->nama = $validasi['nama'];
       $role_group->bobot = $validasi['bobot'];
       $role_group->is_verified = false;
       $role_group->save();

       return back()->with('success', 'Data role group berhasil diperbarui');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $kr, RoleGroupKelompok $roleGroupKelompok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Krs $kr, RoleGroupKelompok $roleGroupKelompok)
    {
        RoleGroupKelompok::find($roleGroupKelompok->id)->delete();
        $role_group_all = RoleGroupKelompok::where('krs_id', $kr->id);
        if($role_group_all->sum('bobot') != 100){
            $role_group_all->update([
                'is_verified' => false,
            ]);
        }
        return back()->with('success', 'Data role group berhasil dihapus');
    }
}
