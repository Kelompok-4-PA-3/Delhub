<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Roles;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::with('user', 'prodi')->latest()->get();
        return view('mahasiswa.index', [
            'mahasiswa' => $mahasiswa,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::latest()->get();
        $prodi = Prodi::latest()->get();
        return view('mahasiswa.add', [
            'prodi' => $prodi,
            'user' => $user
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
            'nim' => 'required|unique:mahasiswas',
            'prodi_id' => 'required',
            'angkatan' => 'required'
        ];

        $validasi = $request->validate($data);
        Mahasiswa::create($validasi);

        return redirect('/mahasiswa')->with('success', 'Data mahasiswa telah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $user = User::latest()->get();
        $prodi = Prodi::latest()->get();
        return view('mahasiswa.edit', [
            'title' => 'Tambah mahasiswa',
            'user' => $user,
            'prodi' => $prodi,
            'mahasiswa' => $mahasiswa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $data = [
            'user_id' => 'required',
            'nim' => 'required',
            'prodi_id' => 'required',
            'angkatan' => 'required'
        ];

        $mhs = Mahasiswa::where('nim', $mahasiswa->nim);

        if ($request->nim != $mahasiswa->nim) {
            $data['nim'] = 'required|unique:mahasiswas';
        }

        $role_mahasiswa = Roles::where('name','mahasiswa')->first();


        if ($role_mahasiswa == NULL) {
            return back()->with('failed', 'Tidak dapat menambahkan mahasiswa karena role mahasiswa tidak ditemukan');
        }

        User::where('id',$request->user_id)->first()->assignRole($role_mahasiswa->id);


        $validasi = $request->validate($data);

        $mhs->update($validasi);

        return redirect('/mahasiswa')->with('success', 'Data mahasiswa telah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $role_mahasiswa = Roles::where('name','mahasiswa')->first();


        if ($role_mahasiswa == NULL) {
            return back()->with('failed', 'Tidak dapat menambahkan mahasiswa karena role mahasiswa tidak ditemukan');
        }

        User::where('id',$request->user_id)->first()->removeRole('mahasiswa');

        Mahasiswa::where('nim', $mahasiswa->nim)->delete();

        return redirect('/mahasiswa')->with('success', 'Data mahasiswa telah berhasil dihapus');
    }
}
