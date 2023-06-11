<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Roles;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'nama_singkat' => [
                'required',
                Rule::unique('dosens', 'nama_singkat')->whereNull('deleted_at'),
                'max:3|min:3'
            ],
            'nidn' => [
                'required',
                Rule::unique('dosens', 'nidn')->whereNull('deleted_at'),
                'numeric'
            ],
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
        $data = $request->validate([
            'user_id' => 'required',
            'nama_singkat' => [
                'required',
                Rule::unique('dosens', 'nama_singkat')->whereNull('deleted_at')->ignore($dosen->id),
                'max:3|min:3'
            ],
            'nidn' => [
                'required',
                Rule::unique('dosens', 'nidn')->whereNull('deleted_at')->ignore($dosen->id),
                'numeric'
            ],
            'prodi_id' => 'required',
        ]);

        $dosen->update($data);

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
