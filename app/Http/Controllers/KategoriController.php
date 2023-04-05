<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriProyek;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::latest()->get();
        $kategori_proyek = KategoriProyek::latest()->get();
        return view('kategori.index',[
            'title' => 'Manajemen Kategori Mata Kuliah',
            'kategori' => $kategori,
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
        // return $request;
        $data = [
            'kode_mk' => 'required',
            'nama_mk' => 'required',
            'nama_singkat' => 'required',
            'kategori_proyek' => 'required',
        ];

        $validasi = $request->validate($data);

        Kategori::create($validasi);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        // return $request;
        $data = [
            'kode_mk' => 'required',
            'nama_mk' => 'required',
            'nama_singkat' => 'required',
            'kategori_proyek' => 'required',
        ];
        $validasi = $request->validate($data);
        $kategori = Kategori::find($kategori->id);
        $kategori->update($validasi);

        return redirect()->back()->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori = Kategori::find($kategori->id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
