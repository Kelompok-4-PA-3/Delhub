<?php

namespace App\Http\Controllers;

use App\Models\krs;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $krs = Krs::latest()->get();
        return view('krs.index',[
            'title' => 'Manajemen KRS',
            'krs' => $krs
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
            'mk_id' => 'required',
            'config_id' => 'required',
            'dosen_mk' => 'required',
            'prodi_id' => 'required',
            'angkatan' => 'required',
        ];
        $validasi = $request->validate($data);
        Krs::create($validasi);
        return redirect()->back()->with('success', 'KRS baru telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(krs $krs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(krs $krs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, krs $krs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(krs $krs)
    {
        //
    }
}
