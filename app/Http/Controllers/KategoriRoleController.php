<?php

namespace App\Http\Controllers;

use App\Models\KategoriRole;
use App\Models\RoleGroupKelompok;
use App\Models\RoleKelompok;
use App\Models\Krs;
use Illuminate\Http\Request;

class KategoriRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Krs $kr)
    {
        $kategori = KategoriRole::where('krs_id',$kr->id)->get();

        return view('dashboard.kategori_role.index',[
            'kategori' => $kategori,
            'krs' => $kr,
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
    public function store(Request $request, Krs $kr)
    {
        $data = [
            'nama' => 'required'
        ];

        if ($request->koordinator) {

                if($kr->kelompok->count() < 1){
                    return back()->with('failed','KRS belum ini memiliki kelompok');
                }

                $koordinator_role = new KategoriRole;
                $koordinator_role->krs_id = $kr->id;
                $koordinator_role->nama = 'koordinator';
                $koordinator_role->save();
               

                $role_group = new RoleGroupKelompok;
                $role_group->kategori_id = $koordinator_role->id;
                $role_group->nama = 'koordinator';
                $role_group->is_main = true;
                $role_group->save();

                // $koordinator = new RoleKelompok;
                // $koordinator->nama = 'koordinator';
                // $koordinator->role_group_id = $koordinator_role->id;
                // $koordinator->kelompok_id = $koordinator_role->id;
                // $koordinator->is_main = true;
                // $koordinator->save();

                foreach ($kr->kelompok as $krk) {
                    RoleKelompok::create([
                        'role_group_id' => $role_group->id,
                        'kelompok_id' => $krk->id,
                        'nidn' => $kr->dosen_mk,
                    ]);
                }
         
                return back()->with('success', 'Role koordinator telah berhasil ditambah pada KRS ini');

        }else{
            if (strtolower($request->nama) == 'koordinator') {
                return back()->with('failed', 'Role koordinator telah terdaftar pada KRS ini');
            }
            
            $validasi = $request->validate($data);
            $validasi['krs_id'] = $kr->id;
            KategoriRole::create($validasi);
    
            return back()->with('success', 'Data kategori role berhasil ditambahkan');
       }

    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriRole $kategori)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriRole $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $kr,  KategoriRole $kategori)
    {
        // return $request;
        $data = [
            'nama' => 'required'
        ];

        $validasi = $request->validate($data);
        $validasi['krs_id'] = $kr->id;
        KategoriRole::find($kategori->id)->update($validasi);

        return back()->with('success', 'Data kategori role berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Krs $kr,  KategoriRole $kategori)
    {
        KategoriRole::find($kategori->id)->delete();
        return back()->with('success', 'Data kategori role berhasil dihapus');
    }
}
