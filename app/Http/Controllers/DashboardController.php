<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\User;
use App\Models\KrsUser;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use App\Models\KategoriProyek;
use Spatie\Permission\Models\Role;
use Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        //
        // return Auth::user()->getRoleNames();
        $pekerjaan_kategori = NULL;
        if ($request->kategori_proyek) {
            $pekerjaan_kategori = KategoriProyek::where('id', $request->kategori_proyek)->first();
        }

        // return $pekerjaan_kategori;
        $role = auth()->user()->getRoleNames()->toArray();
        $krs = Krs::latest()->get();
        $kategori_proyek = KategoriProyek::all();

        return view('dashboard.index', [
            'title' => 'Dashboards',
            'kategori_proyek' => $kategori_proyek,
            'krs' => $krs,
            'pk' => $pekerjaan_kategori,
        ]);
    }

    public function show($id)
    {
        $krs = Krs::where('id', $id)->first();
        $mahasiswa = Mahasiswa::latest()->get();
        $kelompok = Kelompok::where('krs_id', $id)->orderBy('created_at')->get();

        return view('dashboard.detail', [
            'title' => $krs->kategori->nama_mk,
            'krs' => $krs,
            'kelompok' => $kelompok,
            'mahasiswa' => $mahasiswa
        ]);

        return view('dashboard.detail');
    }

    public function add_user(Request $request)
    {

        $data = [
            'mahasiswa' => 'required'
        ];

        $validasi = $request->validate($data);
        foreach ($request->mahasiswa as $m) {
            KrsUser::create([
                'user_id' => $m,
                'krs_id' => $request->krs_id,
            ]);
        }

        return back()->with('success', 'Mahasiswa berhasil ditambahkan ke proyek ini');
    }
}
