<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleCollection;

class ScheduleController extends Controller
{
    public function index()
    {
        $dosen = User::find(auth()->user()->id)->dosen;
        // get jadwal where dosen is pembimbing or penguji of the kelompok
        $jadwals = DB::table('jadwals')
            ->join('kelompoks', 'jadwals.kelompok_id', '=', 'kelompoks.id')
            ->join('role_kelompoks', 'kelompoks.id', '=', 'role_kelompoks.kelompok_id')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->where('kategori_roles.nama', 'pembimbing')
            ->orWhere('kategori_roles.nama', 'penguji')
            ->where('role_kelompoks.nidn', $dosen->nidn)
            ->select('jadwals.*')
            ->get();

        // convert to eloquent model
        $jadwals = Jadwal::hydrate($jadwals->toArray())->load('kelompok.krs.kategori', 'kelompok.pembimbings.user', 'ruangan');

        return ResponseFormatter::success(new ScheduleCollection($jadwals), 'Data berhasil diambil');
    }
}
