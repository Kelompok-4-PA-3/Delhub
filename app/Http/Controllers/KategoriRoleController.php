<?php

namespace App\Http\Controllers;

use App\Models\KategoriRole;
use App\Models\RoleGroupKelompok;
use App\Models\PoinPenilaian;
use App\Models\KomponenPenilaian;
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
        $krs_all = Krs::latest()->get();
        return view('dashboard.kategori_role.index',[
            'kategori' => $kategori,
            'krs' => $kr,
            'krs_all' => $krs_all,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function kategori_role_check_same_name(Krs $kr, $name){
        $kategori_role_kelompok = KategoriRole::where('krs_id', $kr->id)->pluck('nama');
        if (in_array($name, $kategori_role_kelompok->toArray())) {
            return false;
        }else{
            return true;
        }
    }

    private function role_check_same_name(KategoriRole $kr, $name){
        $role_kelompok = RoleGroupKelompok::where('kategori_id', $kr->id)->pluck('nama');
        if (in_array($name, $role_kelompok->toArray())) {
            return false;
        }else{
            return true;
        }
    }

    private function poin_penilaian_check_same_name(Krs $kr, $name){
        $poin_penilaian = PoinPenilaian::where('krs_id', $kr->id)->pluck('nama_poin');
        if (in_array($name, $poin_penilaian->toArray())) {
            return false;
        }else{
            return true;
        }
    }

    private function komponen_penilaian_check_same_name(PoinPenilaian $kr, $name){
        $komponen_penilaian = KomponenPenilaian::where('poin_penilaian_id', $kr->id)->pluck('nama_komponen');
        if (in_array($name, $komponen_penilaian->toArray())) {
            return false;
        }else{
            return true;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Krs $kr)
    {

        // return $request;
        if ($request->krs_copy) {
            // return "Test";

            $krs_copy = Krs::find($request->krs_copy);
            // return $krs_copy->kategori_role;
            foreach ($krs_copy->kategori_role->where('nama','!=','koordinator') as $kkl) {

                if(!$this->kategori_role_check_same_name($kr, $kkl->nama)){
                    return back()->with('error', 'Kategori role sudah digunakan ');
                }

                $kategori_role = new KategoriRole;
                $kategori_role->nama = $kkl->nama;
                $kategori_role->krs_id = $kr->id;
                $kategori_role->save();

                if($request->role){
                    foreach ($kkl->role_group->where('nama','!=','koordinator') as $kklr) {
                        // if(!$this->role_check_same_name($kategori_role->role_group, $kklr->nama)){
                        //     return back()->with('error', 'Role sudah digunakan ');
                        // }

                        $role_group_copy = new RoleGroupKelompok;
                        $role_group_copy->nama = $kklr->nama;
                        $role_group_copy->kategori_id = $kategori_role->id;
                        if($kklr->is_main){
                            $role_group_copy->is_main = true;
                        }
                        $role_group_copy->save();
                    }

                }

            // return "test";


            }


            if ($request->poin_penilaian) {
                foreach ($krs_copy->poin_penilaian as $pp) {

                    if(!$this->poin_penilaian_check_same_name($kr, $pp->nama)){
                        return back()->with('error', 'Poin penilaian sudah digunakan ');
                    }

                    $poin_penilaian_new = new PoinPenilaian();
                    $poin_penilaian_new->nama_poin = $pp->nama_poin;
                    $poin_penilaian_new->bobot = $pp->bobot;
                    $poin_penilaian_new->krs_id = $kr->id;
                    $poin_penilaian_new->save();       

                    if ($request->komponen_penilaian) {
                        foreach ($pp->komponen_penilaian as $ppk) { 
                            // if(!$this->komponen_penilaian_check_same_name($pp, $ppk->nama)){
                            //     return back()->with('error', 'Komponen penilaian sudah digunakan ');
                            // }

                            KomponenPenilaian::create([
                                'poin_penilaian_id' => $poin_penilaian_new->id,
                                'nama_komponen' => $ppk->nama_komponen,
                                'bobot' => $ppk->bobot
                            ]);  
                        }
                    }
                }
            }



            return back()->with('success', 'Data berhasil dicopy');
        }

        $data = [
            'nama' => 'required'
        ];

        $kategori_role_kelompok = KategoriRole::where('krs_id', $kr->id)->pluck('nama');
        if (in_array($request->nama, $kategori_role_kelompok->toArray())) {
            return back()->with('error', 'Nama role ini sudah digunakan ');
        }

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
                        'nama_role' => $role_group->id,
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
     

        $data = [
            'nama' => 'required'
        ];


        $kategori_role_kelompok = KategoriRole::where('krs_id', $kr->id)->pluck('nama');
        
        if ($request->nama != $kategori->nama) {
            if (in_array($request->nama, $kategori_role_kelompok->toArray())) {
                return back()->with('error', 'Nama role ini sudah digunakan ');
            }
        }

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
