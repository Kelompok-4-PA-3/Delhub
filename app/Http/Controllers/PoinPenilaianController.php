<?php

namespace App\Http\Controllers;

use App\Models\PoinPenilaian;
use App\Models\KomponenPenilaian;
use App\Models\RoleGroupKelompok;
use App\Models\RoleGroupPenilaian;
use App\Models\Krs;
use Illuminate\Http\Request;

class PoinPenilaianController extends Controller
{

    public function index(Krs $kr)
    {   
        $poin_penilaian = PoinPenilaian::where('krs_id',$kr->id)->get();
        $role_krs = RoleGroupKelompok::join('kategori_roles','role_group_kelompoks.kategori_id','kategori_roles.id')
                                        ->where('kategori_roles.krs_id',$kr->id)
                                        ->select('role_group_kelompoks.*')->get();
        $krs_all = Krs::latest()->get();
        // return $role_krs;

        return view('dashboard.poinpenilaian.index',[
            'title' => $kr->kategori->nama_mk,
            'poin_penilaian' => $poin_penilaian,
            'krs' => $kr,
            'role_krs' => $role_krs,
            'krs_all' => $krs_all,
        ]);
    }


    public function create()
    {
        
    }


    public function store(Request $request, Krs $kr)
    {   
        // return $request;

        if ($request->krs_copy) {
            $krs_copy = Krs::find($request->krs_copy);
            foreach ($krs_copy->poin_penilaian as $pp) {

                $poin_penilaian_new = new PoinPenilaian();
                $poin_penilaian_new->nama_poin = $pp->nama_poin;
                $poin_penilaian_new->bobot = $pp->bobot;
                $poin_penilaian_new->krs_id = $kr->id;
                $poin_penilaian_new->save();       

                if ($request->komponen_penilaian) {
                    foreach ($pp->komponen_penilaian as $ppk) { 
                        $komponen_penilaian_new = new KomponenPenilaian();
                        $komponen_penilaian_new->poin_penilaian_id = $poin_penilaian_new->id;
                        $komponen_penilaian_new->nama_komponen = $ppk->nama_komponen;
                        $komponen_penilaian_new->bobot = $ppk->bobot;
                        $komponen_penilaian_new->save();

                    }

                       
                }


            }

            return back()->with('success', 'Data berhasil dicopy');

        }



        // return $request;
        $data = [
            'nama_poin' => 'required',
            'bobot' => 'required',
        ];

        $validasi = $request->validate($data);

        $poin_penilaian = new PoinPenilaian();
        $poin_penilaian->krs_id =  $kr->id;
        $poin_penilaian->nama_poin = $validasi['nama_poin'];
        $poin_penilaian->bobot= $validasi['bobot'];
        $poin_penilaian->save();      

        return back()->with('success','Poin penilaian telah berhasil dibuat');
    }

    public function store_role(Request $request, Krs $kr, PoinPenilaian $penilaian)
    {   
        // return $request; 
        $data = [
            'role_group_id' => 'required',
            'bobot' => 'required',
        ];

        $validasi = $request->validate($data);
        $validasi['krs_id'] = $kr->id;
        $validasi['poin_penilaian_id'] = $penilaian->id;

        $cek_role = RoleGroupPenilaian::where('poin_penilaian_id', $penilaian->id)
                                        ->where('role_group_id', $validasi['role_group_id'])->first();
        // return $cek_role;

        if($cek_role != NULL){  
            // return "samaa";
            return back()->with('error','Role tersebut telah terdaftar pada poin penilaian ini')->with("store", $penilaian->id);
        }

        // return $

        // foreach ($request->role_group_id as $rg) {
         RoleGroupPenilaian::create($validasi);
        // }       

        return back()->with('success','Poin penilaian telah berhasil dibuat')->with("store", $penilaian->id);
    }

    public function role_verifikasi(Request $request, Krs $kr, PoinPenilaian $penilaian)
    {   
        // return $request; 
        $rolePenilaian = RoleGroupPenilaian::where('poin_penilaian_id', $penilaian->id);

        if($request->cancel){
            $rolePenilaian->update([
                'is_verified' => false
            ]);

            return back()->with('success','Verfikasi telah berhasil dibatalkan');
        }
        // return $rolePenilaian->get();
        if($rolePenilaian->sum('bobot') == 100){
            $rolePenilaian->update([
                'is_verified' => true
            ]);

            return back()->with('success','Verfikasi telah berhasil dilakukan');
        }

        return back()->with('error','Total bobot role tidak mencapai atau melebihi 100%');
    }

    public function delete_role(Request $request, Krs $kr, PoinPenilaian $penilaian, RoleGroupPenilaian $role_penilaian)
    {  
        $rolePenilaian = RoleGroupPenilaian::where('poin_penilaian_id', $penilaian->id);

        $rolePenilaian->update([
            'is_verified' => false
        ]);

        RoleGroupPenilaian::where('id', $role_penilaian->id)->delete();
        return back()->with('success','Role telah berhasil dihapus')->with("store", $penilaian->id);
    }

    public function verifikasi_poin_penilaian(Krs $kr){
        $poin_penilaian =PoinPenilaian::where('krs_id', $kr->id);
        if($poin_penilaian->sum('bobot') != 100){
            return  back()->with('error','Sepertinya jumlah bobot tidak mencapai 100% atau melebihinya, pastikan jumlah keseluruhan bobot mencapai tepat 100%');
        }

        $poin_penilaian->where('is_verified',false)->update([
            'is_verified' => true,
        ]);

        return back()->with('success','Verifikasi poin penilaian telah berhasil');
    }


    public function show(PoinPenilaian $poinPenilaian)
    {
        
    }


    public function edit(PoinPenilaian $poinPenilaian)
    {
       
    }


    public function update(Request $request,Krs $kr,PoinPenilaian $poinPenilaian)
    {
        // return $data;
        $data = [
            'nama_poin' => 'required',
            'bobot' => 'required',
        ];

        $validasi = $request->validate($data);
        $poin_penilaian = PoinPenilaian::find($poinPenilaian->id);
        $poin_penilaian->nama_poin = $validasi['nama_poin'];
        $poin_penilaian->bobot = $validasi['bobot'];
        $poin_penilaian->is_verified = false;
        $poin_penilaian->save(); 

        return back()->with('success','poin penilaian telah berhasil duperbarui');
    }


    public function delete(Krs $kr,PoinPenilaian $poinPenilaian)
    {
        $poin_penilaian = PoinPenilaian::find($poinPenilaian->id)->delete();
        $poin_penilaian_all = PoinPenilaian::where('krs_id', $kr->id);

        if($poin_penilaian_all->sum('bobot') != 100){
            $poin_penilaian_all->update([
                'is_verified' => false,
            ]);
        }

        return back()->with('success','Poin penilaian telah berhasil dihapus');

    }

    public function komponen_penilaian(Krs $kr,PoinPenilaian $poinPenilaian){
        $komponen_penilaian = KomponenPenilaian::where('poin_penilaian_id', $poinPenilaian->id)->get();

        return view('dashboard.poinpenilaian.komponen_penilaian.index',[
            'komponen_penilaian' => $komponen_penilaian,
            'title' => $poinPenilaian->nama_poin,
            'krs' => $kr
        ]);

    }
}
