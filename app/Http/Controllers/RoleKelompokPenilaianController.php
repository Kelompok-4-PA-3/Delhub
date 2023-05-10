<?php

namespace App\Http\Controllers;

use App\Models\RoleKelompokPenilaian;
use App\Models\RoleGroupKelompok;
use App\Models\Krs;
use Illuminate\Http\Request;

class RoleKelompokPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Krs $kr, RoleGroupKelompok $role)
    {   
         $role_komponen = RoleKelompokPenilaian::where('role_group_id',$role->id)->get();

         return view('dashboard.rolegroup.komponen',[
             'title' => $role->nama,
             'role_komponen' => $role_komponen,
             'role' => $role,
             'krs' => $kr
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function verifikasi_kompnen_penilaian(Krs $kr, RoleGroupKelompok $role)
    {   
        $komponen_nilai = RoleKelompokPenilaian::where('role_group_id',$role->id);
        if ($komponen_nilai->sum('bobot') == 100)
        {
            $komponen_nilai->update([
                'is_verified' => true
            ]);
        }else{
            return back()->with('failed','Sepertinya jumlah bobot tidak mencapai 100% atau melebihinya, pastikan jumlah keseluruhan bobot mencapai tepat 100%');
        }
       
        return back()->with('success','Data telah berhasil diverifikasi');

    }
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Krs $kr, RoleGroupKelompok $role)
    {
        $data = [
            'nama' => 'required',
            'bobot' => 'required|numeric'
        ];
        // return $role->id;
        $validasi = $request->validate($data);
        $validasi['role_group_id'] = $role->id;
        // return $validasi;

        RoleKelompokPenilaian::create($validasi);
        return back()->with('success','Komponen penilai telah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleKelompokPenilaian $roleKelompokPenilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleKelompokPenilaian $roleKelompokPenilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $kr, RoleGroupKelompok $role, RoleKelompokPenilaian $rolePenilaian)
    {
        // return $rolePenilaian;
        $data = [
            'nama' => 'required',
            'bobot' => 'required|numeric'
        ];
        $validasi = $request->validate($data);

        RoleKelompokPenilaian::find($rolePenilaian->id)->update([
            'nama' => $validasi['nama'],
            'bobot' => $validasi['bobot'],
            'is_verified' => false,
        ]);
        return back()->with('success','Komponen penilai telah berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Krs $kr, RoleGroupKelompok $role, RoleKelompokPenilaian $rolePenilaian)
    {
        $komponen_nilai = RoleKelompokPenilaian::wherer('id',$rolePenilaian->id);
        $komponen_nilai->delete();
        $komponen_nilai->update([
            'is_verified' => false
        ]);
        return back()->with('success','Data telah berhasil dihapus');
    }
}
