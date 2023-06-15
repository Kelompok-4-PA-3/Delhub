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
        // get kelompok where dosen is pembimbing or penguji and krs_id is $id
        // select kelompoks.* and kategori_roles.nama

        $kelompoks = DB::table('kelompoks')
            ->join('role_kelompoks', 'kelompoks.id', '=', 'role_kelompoks.kelompok_id')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->whereIn('kategori_roles.nama', ['Pembimbing', 'Penguji'])
            ->where('role_kelompoks.nidn', $dosen->nidn)
            ->where('kelompoks.krs_id', $id)
            ->where('kelompoks.deleted_at', null)
            ->where('kategori_roles.deleted_at', null)
            ->select('kelompoks.*', 'kategori_roles.nama as kategori')
            ->get();

        // get kelompok by id, load pembimbing, krs, mahasiswa, prodi, user, bimbingan what is role dosen to kelompok
        $kelompoks = Kelompok::hydrate($kelompoks->toArray())->load('pembimbings.user', 'krs', 'mahasiswas.prodi', 'mahasiswas.user', 'bimbingan', 'pengujis.user');
        return ResponseFormatter::success(new KelompokCollection($kelompoks), 'Data berhasil diambil');
    }
}
