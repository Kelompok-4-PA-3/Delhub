<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Roles;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosen = Dosen::with('user', 'prodi')->latest()->get();
        return view('dosen.index', [
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
        return view('dosen.add', [
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
            'nama_singkat' => 'required|unique:dosens,nama_singkat,NULL,nidn,deleted_at,NULL|max:3|min:3',
            'nidn' => 'required|numeric|unique:dosens,nidn,NULL,nidn,deleted_at,NULL',
            'prodi_id' => 'required',
        ];

        $role_dosen = Roles::where('name', 'dosen')->first();


        if ($role_dosen == NULL) {
            return back()->with('failed', 'Tidak dapat menambahkan dosen karena role dosen tidak ditemukan');
        }

        User::where('id', $request->user_id)->first()->assignRole($role_dosen->id);

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
        return view('dosen.edit', [
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
            'nama_singkat' => 'required',
            'nidn' => 'required',
            'prodi_id' => 'required',
        ];

        if ($request->nama_singkat != $dosen->nama_singkat) {
            $data['nama_singkat'] = 'required|unique:dosens,nama_singkat,' . $dosen->nidn . ',nidn,deleted_at,NULL|max:3|min:3';
        }

        $dsn = Dosen::where('nidn', $dosen->nidn);
        // return $request->nidn ;
        if ($request->nidn != $dosen->nidn) {
            $data['nidn'] =  'required|numeric|unique:dosens,nidn,' . $dosen->nidn . ',nidn,deleted_at,NULL';
        }

        $validasi = $request->validate($data);
        $dsn->update($validasi);

        return redirect('/dosen')->with('success', 'Data dosen telah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        $role_dosen = Roles::where('name', 'dosen')->first();
        if ($role_dosen == NULL) {
            return back()->with('failed', 'Tidak dapat menambahkan dosen karena role dosen tidak ditemukan');
        }
        User::where('id', $dosen->user_id)->first()->removeRole('dosen');
        Dosen::where('nidn', $dosen->nidn)->delete();
        return redirect('/dosen')->with('success', 'Data dosen telah berhasil dihapus');
    }
}
