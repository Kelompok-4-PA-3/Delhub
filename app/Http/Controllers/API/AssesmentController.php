<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssesmentPointCollection;
use App\Models\PoinPenilaian;
use Illuminate\Support\Facades\DB;

class AssesmentController extends Controller
{
    public function getAssesmentPointByGroupId($id){

        $dosen = User::find(auth()->user()->id)->dosen;
        // check if dosen role to the group
        $check = DB::table('role_kelompoks')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->where('kategori_roles.nama', 'pembimbing')
            ->where('role_kelompoks.nidn', $dosen->nidn)
            ->where('role_kelompoks.kelompok_id', $id)
            ->select('role_kelompoks.*')
            ->first();


            // get point_penilaians by role id dosen in table role_group_penilaians
            $assesmentPoints = DB::table('role_group_penilaians')
                ->join('poin_penilaians', 'role_group_penilaians.poin_penilaian_id', '=', 'poin_penilaians.id')
                ->where('role_group_penilaians.role_group_id', $check->role_group_id)
                ->select('poin_penilaians.*')
                ->get();

                // convert to eloquent
            $assesmentPoints = PoinPenilaian::hydrate($assesmentPoints->toArray())->load('komponen_penilaian');
        return ResponseFormatter::success(
            new AssesmentPointCollection($assesmentPoints),
            'Data berhasil diambil'
        );
    }
}
