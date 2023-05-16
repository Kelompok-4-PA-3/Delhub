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
        $role_krs = RoleGroupKelompok::where('krs_id',$kr->id)->get();

        return view('dashboard.poinpenilaian.index',[
            'title' => $kr->kategori->nama_mk,
            'poin_penilaian' => $poin_penilaian,
            'krs' => $kr,
            'role_krs' => $role_krs,
        ]);
    }


    public function create()
    {
        
    }


    public function store(Request $request, Krs $kr)
    {   
        // return $request;
        $data = [
            'krs_id' => 'required',
            'nama_poin' => 'required',
            'bobot' => 'required',
        ];

        $validasi = $request->validate($data);

        $poin_penilaian = new PoinPenilaian();
        $poin_penilaian->krs_id = $validasi['krs_id'];
        $poin_penilaian->nama_poin = $validasi['nama_poin'];
        $poin_penilaian->bobot= $validasi['bobot'];
        $poin_penilaian->save();
        foreach ($request->role_group_id as $rg) {
            RoleGroupPenilaian::create([
                'role_group_id' => $rg,
                'poin_penilaian_id' => $poin_penilaian->id
            ]);
        }       

        return back()->with('success','Poin penilaian telah berhasil dibuat');
    }

    public function verifikasi_poin_penilaian(Krs $kr){
        $poin_penilaian =PoinPenilaian::where('krs_id', $kr->id);
        if($poin_penilaian->sum('bobot') != 100){
            return  back()->with('failed','Sepertinya jumlah bobot tidak mencapai 100% atau melebihinya, pastikan jumlah keseluruhan bobot mencapai tepat 100%');
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

        RoleGroupPenilaian::where('poin_penilaian_id', $poin_penilaian->id)->delete();
        // return $request->role_group_id;
        foreach ($request->role_group_id as $rg) {
            RoleGroupPenilaian::create([
                'role_group_id' => $rg,
                'poin_penilaian_id' => $poin_penilaian->id
            ]);
        }    

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
