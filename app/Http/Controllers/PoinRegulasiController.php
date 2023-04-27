<?php

namespace App\Http\Controllers;

use App\Models\PoinRegulasi;
use App\Models\KategoriProyek;
use Illuminate\Http\Request;

class PoinRegulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $poin_regulasi = PoinRegulasi::latest()->get();
        $kategori_proyek = KategoriProyek::latest()->get();
        return view('poin_regulasi.index',[
            'title' => 'Poin Regulasi',
            'poin_regulasi' => $poin_regulasi,
            'kategori_proyek' => $kategori_proyek
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
    public function store(Request $request)
    {
    //    return $request;
       $data = [
        'nama' => 'required',
        'poin' => 'required',
        'kategori_id' => 'required',
       ];

       $validasi = $request->validate($data);

       PoinRegulasi::create($validasi);

       return back()->with('success','Data poin regulasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PoinRegulasi $poinRegulasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PoinRegulasi $poinRegulasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PoinRegulasi $poinRegulasi)
    {
        $data = [
            'nama_edit' => 'required',
            'poin' => 'required',
            'kategori_id' => 'required',
        ];

        $validasi = $request->validate($data);

        $poin_regulasi = PoinRegulasi::find($poinRegulasi->id);
        $poin_regulasi->nama = $validasi['nama_edit'];
        $poin_regulasi->poin = $validasi['poin'];
        $poin_regulasi->kategori_id = $validasi['kategori_id'];
        $poin_regulasi->save();
 
        return back()->with('success','Data poin regulasi berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PoinRegulasi $poinRegulasi)
    {
        $poinRegulasi = PoinRegulasi::find($poinRegulasi->id);
        $poinRegulasi->delete();

        return redirect()->back()->with('success', 'Poin regulasi berhasil dihapus');
    }
}
