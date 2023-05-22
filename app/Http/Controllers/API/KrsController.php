<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\KrsCollection;

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
            ->get();

        return ResponseFormatter::success(new KrsCollection($krs), 'Data berhasil diambil');
    }
}
