<?php

namespace App\Http\Controllers;

use App\Models\Regulasi;
use App\Models\Krs;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class RegulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {   
        $krs = Krs::where('id', $id)->first();
        $kelompok = Kelompok::where('krs_id', $id)->get();
        $regulasi = Regulasi::where('krs_id', '=', $id)->first();
        return view('dashboard.regulasi.index', [
            'title' => 'Regulasi',
            'krs' => $krs,
            'kelompok' => $kelompok,
            'regulasi' => $regulasi,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $krs = Krs::where('id', $id)->first();
        return view('dashboard.regulasi.add', [
            'title' => 'Regulasi',
            'krs' => $krs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $regulasi = Regulasi::where('krs_id', '=', $request->krs_id)->first();

        if ($regulasi->count() > 0) {
            return abort(404);
        }
        
        $data = [
            'krs_id' => 'required', 
            'seminar' => 'required', 
            'sidang' => 'required', 
            'prasidang' => 'required', 
            'proposal' => 'required', 
        ];

        $validasi = $request->validate($data);

        Regulasi::create($validasi);

        return back()->with('success', 'Regulasi telah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $krs = Krs::where('id', $id)->first();
        $kelompok = Kelompok::where('krs_id', $id)->get();
        $regulasi = Regulasi::where('krs_id', '=', $id)->first();
        return view('dashboard.regulasi.detail', [
            'title' => 'Regulasi',
            'krs' => $krs,
            'kelompok' => $kelompok,
            'regulasi' => $regulasi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Regulasi $regulasi)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = [ 
            'seminar' => 'required', 
            'sidang' => 'required', 
            'prasidang' => 'required', 
            'proposal' => 'required', 
            'regulasi' => 'required', 
        ];

        $validasi = $request->validate($data);

        Regulasi::find($request->regulasi)->update($validasi);

        return back()->with('success', 'Regulasi telah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Regulasi $regulasi)
    {
        //
    }
}
