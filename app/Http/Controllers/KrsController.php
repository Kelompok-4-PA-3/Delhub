<?php

namespace App\Http\Controllers;

use App\Models\krs;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Kategori;
use App\Models\Configs;
use App\Models\Mahasiswa;
use App\Models\KrsUser;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kr = Krs::latest()->get();
        return view('krs.index',[
            'title' => 'Manajemen KRS',
            'krs' => $kr
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $dosen = Dosen::latest()->get();
        $prodi = Prodi::latest()->get();
        $kategori = Kategori::latest()->get();
        $config = Configs::latest()->get();
        return view('krs.add',[
            'prodi' => $prodi,
            'dosen' => $dosen,
            'kategori' => $kategori,
            'config' => $config
        ]);
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
            'dosen_mk_2' => 'nullable',
            'prodi_id' => 'required',
            'angkatan' => 'required',
        ];
        $validasi = $request->validate($data);
        $krs = Krs::create($validasi);
        $mahasiswa = Mahasiswa::where('prodi_id', $validasi['prodi_id'])->where('angkatan',$validasi['angkatan'])->get();

        if($mahasiswa->count() > 0){
            $krs_mahasiswa = new KrsUser();
            foreach ($mahasiswa as $m) {
                $krs_mahasiswa->create([
                    'user_id' => $m->user_id,
                    'krs_id' => $krs->id
                ]);
            }
        }

        return redirect('/krs')->with('success', 'KRS baru telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(krs $kr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(krs $kr)
    {    
        $dosen = Dosen::latest()->get();
        $prodi = Prodi::latest()->get();
        $kategori = Kategori::latest()->get();
        $config = Configs::latest()->get();
        return view('krs.edit',[
            'krs' => $kr,
            'prodi' => $prodi,
            'dosen' => $dosen,
            'kategori' => $kategori,
            'config' => $config
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, krs $kr)
    {
        $data = [
            'mk_id' => 'required',
            'config_id' => 'required',
            'dosen_mk' => 'required',
            'dosen_mk_2' => 'nullable',
            'prodi_id' => 'required',
            'angkatan' => 'required',
        ];
        $validasi = $request->validate($data);
        Krs::find($kr->id)->update($validasi);
        return redirect('/krs')->with('success', 'KRS baru telah berhasil dibuat');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(krs $kr)
    {
        Krs::find($kr->id)->delete();
        return redirect('/krs')->with('success', 'KRS tekah berhasil dihapus');
    }
}
