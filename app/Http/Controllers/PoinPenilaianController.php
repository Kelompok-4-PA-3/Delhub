<?php

namespace App\Http\Controllers;

use App\Models\PoinPenilaian;
use App\Models\KomponenPenilaian;
use App\Models\Krs;
use Illuminate\Http\Request;

class PoinPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Krs $kr)
    {   

        $poin_penilaian = PoinPenilaian::latest()->get();

        return view('dashboard.poinpenilaian.index',[
            'title' => $kr->kategori->nama_mk,
            'poin_penilaian' => $poin_penilaian,
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

        return back()->with('success','Poin penilaian telah berhasil dibuat');
    //    return $kr;
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

    /**
     * Display the specified resource.
     */
    public function show(PoinPenilaian $poinPenilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PoinPenilaian $poinPenilaian)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Krs $kr,PoinPenilaian $poinPenilaian)
    {
        $data = [
            'nama_poin' => 'required',
            'bobot' => 'required',
        ];

        $validasi = $request->validate($data);
        // $validasi['poin_regulasi_id'] = $poinRegulasi->id;
        $poin_penilaian = PoinPenilaian::find($poinPenilaian->id);
        // return $poin_penilaian;
        $poin_penilaian->nama_poin = $validasi['nama_poin'];
        $poin_penilaian->bobot = $validasi['bobot'];
        $poin_penilaian->is_verified = false;
        $poin_penilaian->save();
        return back()->with('success','poin penilaian telah berhasil duperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
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
