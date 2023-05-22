<?php

namespace App\Http\Controllers;

use App\Models\RoleGroupKelompok;
use App\Models\RoleKelompok;
use App\Models\KategoriRole;
use App\Models\Krs; 
use Illuminate\Http\Request;

class RoleGroupKelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Krs $kr, KategoriRole $kategori)
    {
        // return $kr;
        $role_group = RoleGroupKelompok::where('kategori_id',$kategori->id)->get();
        // $role_kelompok = RoleKelompok::latest()();
        // return $role_kelompok;
        return view('dashboard.rolegroup.index',[
            'role_group' => $role_group,
            'kategori' => $kategori,
            'krs' => $kr,
        ]);
    }

    public function verifikasi_role_group(Request $request, Krs $kr, KategoriRole $kategori, RoleGroupKelompok $role)
    {
        $role_group =RoleGroupKelompok::find($role->id);

        if($request->cancel){
            $role_group->update([
                'is_verified' => false,
            ]);

            return back()->with('success','Verifikasi bobot role telah berhasil dibatalkan');
        }

        if($role_group->komponen_penilaian->sum('bobot') != 100){
            return  back()->with('failed','Sepertinya jumlah bobot tidak mencapai 100% atau melebihinya, pastikan jumlah keseluruhan bobot mencapai tepat 100%');
        }

        $role_group->update([
            'is_verified' => true,
        ]);

        return back()->with('success','Verifikasi bobot role telah berhasil');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Krs $kr, KategoriRole $kategori)
    {
       $data = [
            'nama' => 'required',
            // 'bobot' => 'required|numeric|max:100|min:0',
       ];
       
       

    //    if ($request->koordinator) {
    //         $validasi = $request->validate($data);
    //         // $validasi['krs_id'] = $kr->id;
    //         // $validasi['nama'] = 'Koordinator';
    //         // RoleGroupKelompok::create($validasi);
    //         $koordinator = new RoleGroupKelompok;
    //         $koordinator->nama = $validasi['nama'];
    //         $koordinator->bobot = $validasi['bobot'];
    //         $koordinator->krs_id = $kr->id;
    //         $koordinator->save();

    //         foreach ($kr->kelompok as $krk) {
    //             RoleKelompok::create([
    //                 'role_group_id' => $koordinator->id,
    //                 'kelompok_id' => $krk->id,
    //                 'nidn' => $kr->dosen_mk,
    //             ]);
    //         }

    //    }else{
            // if (strtolower($request->nama) == 'koordinator') {
            //     return back()->with('failed', 'Role koordinator telah terdaftar pada KRS ini');
            // }
            
            $validasi = $request->validate($data);
            $validasi['kategori_id'] = $kategori->id;
            if($request->is_main){
                $validasi['is_main'] = 1;
            }
            RoleGroupKelompok::create($validasi);
    //    }

       return back()->with('success', 'Data role group berhasil ditambahkan');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Krs $kr, KategoriRole $kategori, RoleGroupKelompok $roleGroupKelompok)
    {
        $data = [
            'nama' => 'required',
       ];
       $role_group = RoleGroupKelompok::find($roleGroupKelompok->id);
       

       $validasi = $request->validate($data);
       if($request->is_main){
            // return 
            $validasi['is_main'] = 1;
       }else{
            $validasi['is_main'] = 0;
       }
       $validasi['kategori_id'] = $kategori->id;
       $role_group->nama = $validasi['nama'];
       $role_group->is_main = $validasi['is_main'];
       $role_group->save();

       return back()->with('success', 'Data role group berhasil diperbarui');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $kr, KategoriRole $kategori, RoleGroupKelompok $roleGroupKelompok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Krs $kr, KategoriRole $kategori, RoleGroupKelompok $roleGroupKelompok)
    {
        RoleGroupKelompok::find($roleGroupKelompok->id)->delete();
        // $role_group_all = RoleGroupKelompok::where('krs_id', $kr->id);
        // if($role_group_all->sum('bobot') != 100){
        //     $role_group_all->update([
        //         'is_verified' => false,
        //     ]);
        // }
        return back()->with('success', 'Data role group berhasil dihapus');
    }
}
