<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProyek;
use Illuminate\Validation\Rule;

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
        $data = $request->validate([
            'nama' => [
                'required',
                Rule::unique('kategori_proyeks', 'nama')->whereNull('deleted_at')
            ]
        ]);

        KategoriProyek::create($data);

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
        // $data = ['nama_edit' => 'required'];


        // if ($request->nama_edit != $kategoriProyek->nama) {
        //     $data['nama_edit'] =
        // }
        $data = $request->validate([
            'nama' => [
                'required',
                Rule::unique('kategori_proyeks', 'nama')->whereNull('deleted_at')->ignore($kategoriProyek->id)
            ]
        ]);

        $kategoriProyek->update($data);

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
