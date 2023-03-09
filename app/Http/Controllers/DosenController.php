<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $dosen =Dosen::latest()->get();
        return view('dosen.index',[
            'title' => 'Manajemen Dosen',
            'dosen' => $dosen,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $user = User::latest()->get();
        $prodi = Prodi::latest()->get();
        return view('dosen.add',[
            'title' => 'Tambah Dosen',
            'user' => $user,
            'prodi' => $prodi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $data = [
            'user_id' => 'required',
            'nidn' => 'required|numeric|unique:dosens',
            'prodi_id' => 'required',
        ];

        $validasi = $request->validate($data);
        Dosen::create($validasi);

        return redirect('/dosen')->with('success', 'Data dosen telah berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        $user = User::latest()->get();
        $prodi = Prodi::latest()->get();
        return view('dosen.edit',[
            'title' => 'Tambah Dosen',
            'user' => $user,
            'prodi' => $prodi,
            'dosen' => $dosen,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        // return "ini update";
        $data = [
            'user_id' => 'required',
            'nidn' => 'required|numeric|unique:dosens',
            'prodi_id' => 'required',
        ];

        $validasi = $request->validate($data);
        // return $dosen->nidn;
        Dosen::where('nidn',$dosen->nidn)->update($validasi);

        return redirect('/dosen')->with('success', 'Data dosen telah berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        Dosen::where('nidn',$dosen->nidn)->delete();
        return redirect('/dosen')->with('success', 'Data dosen telah berhasil dihapus');
    }
}
