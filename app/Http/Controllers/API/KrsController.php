<?php

namespace App\Http\Controllers\API;

use App\Models\Krs;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\KrsCollection;
use App\Http\Resources\KelompokCollection;
use App\Models\Kelompok;

class KrsController extends Controller
{
    public function index()
    {
        $dosen = User::find(auth()->user()->id)->dosen;
        $krs = DB::table('krs')
            ->join('kelompoks', 'krs.id', '=', 'kelompoks.krs_id')
            ->join('role_kelompoks', 'kelompoks.id', '=', 'role_kelompoks.kelompok_id')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->where('kategori_roles.nama', 'pembimbing')
            ->where('role_kelompoks.nidn', $dosen->nidn)
            ->select('krs.*')
            ->distinct()
            ->get();

        // convert to eloquent model
        $krs = Krs::hydrate($krs->toArray())->load('kategori', 'dosen.user');

        return ResponseFormatter::success(new KrsCollection($krs), 'Data berhasil diambil');
    }

    public function getKelompoks($id)
    {
        $dosen = User::find(auth()->user()->id)->dosen;
        $kelompoks = DB::table('kelompoks')
            ->join('role_kelompoks', 'kelompoks.id', '=', 'role_kelompoks.kelompok_id')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->where('kategori_roles.nama', 'pembimbing')
            ->where('role_kelompoks.nidn', $dosen->nidn)
            ->where('kelompoks.krs_id', $id)
            ->select('kelompoks.*')
            ->get();

        $kelompoks = Kelompok::hydrate($kelompoks->toArray())->load('pembimbings.user', 'krs.kategori', 'mahasiswas.prodi', 'mahasiswas.user', 'bimbingan');
        return ResponseFormatter::success(new KelompokCollection($kelompoks), 'Data berhasil diambil');
    }
}
