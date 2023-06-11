<?php

namespace App\Http\Controllers;

use App\Models\KategoriProyek;
use Illuminate\Http\Request;

class KategoriProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori_proyek = KategoriProyek::latest()->get();

        return view('kategori_proyek.index', [
            'title' => 'Kategori Proyek',
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
        $data = ['nama' => 'required|unique:kategori_proyeks,nama,NULL,id,deleted_at,NULL'];
        $validasi = $request->validate($data);
        KategoriProyek::create($validasi);

        return redirect()->back()->with('success', 'Kategori proyek telah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriProyek $kategoriProyek)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriProyek $kategoriProyek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriProyek $kategoriProyek)
    {
        $data = ['nama_edit' => 'required'];


        if ($request->nama_edit != $kategoriProyek->nama) {
            $data['nama_edit'] = 'unique:kategori_proyeks,nama,' . $kategoriProyek->id . ',id,deleted_at,NULL';
        }

        $validasi = $request->validate($data);
        $kategori = KategoriProyek::find($kategoriProyek->id);
        $kategori->nama = $validasi['nama_edit'];
        $kategori->save();

        return redirect()->back()->with('success', 'Kategori proyek telah berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriProyek $kategoriProyek)
    {
        // return $kategoriProyek;
        $kproyek = KategoriProyek::where('id', $kategoriProyek->id)->first();
        $kproyek->delete($kategoriProyek);

        return back()->with('success', 'kategori proyek telah berhasil di hapus');
    }
}
