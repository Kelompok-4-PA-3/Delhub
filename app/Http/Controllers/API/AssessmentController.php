<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PoinPenilaian;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DetailNilaiMahasiswa;
use App\Http\Resources\AssessmentPointCollection;
use App\Http\Resources\AssessmentStudentCollection;
use App\Models\Kelompok;
use App\Models\NilaiMahasiswa;
use App\Models\RoleKelompok;

class AssessmentController extends Controller
{
    public function getAssessmentPointByGroupId($id){
        $dosen = User::find(auth()->user()->id)->dosen;
        // check if dosen role to the group
        $check = DB::table('role_kelompoks')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->where('role_kelompoks.nidn', $dosen->nidn)
            ->where('role_kelompoks.kelompok_id', $id)
            ->where('role_kelompoks.deleted_at', null)
            ->select('role_kelompoks.*')
            ->first();


            // get point_penilaians by role id dosen in table role_group_penilaians
            $assessmentPoints = DB::table('role_group_penilaians')
                ->join('poin_penilaians', 'role_group_penilaians.poin_penilaian_id', '=', 'poin_penilaians.id')
                ->where('role_group_penilaians.role_group_id', $check->role_group_id)
                ->where('poin_penilaians.deleted_at', null)
                ->select('poin_penilaians.*')
                ->get();

                // convert to eloquent
            $assessmentPoints = PoinPenilaian::hydrate($assessmentPoints->toArray())->load('komponen_penilaian');
        return ResponseFormatter::success(
            new AssessmentPointCollection($assessmentPoints),
            'Data berhasil diambil'
        );
    }

    public function getAssessmentStudents($id){
        // get kelompok by id, load pembimbing, krs, mahasiswa, prodi, user, bimbingan what is role dosen to kelompok
        $kelompok = Kelompok::find($id)->load('pembimbings.user', 'krs', 'mahasiswas.prodi', 'mahasiswas.user', 'bimbingan', 'pengujis.user');
        if (!$kelompok) {
            return ResponseFormatter::error(
                null,
                'Data Kelompok tidak ada',
                404
            );
        }

        // get assessmentstudents by kelompok_id
        $assessmentStudents = DB::table('nilai_mahasiswas')
            ->join('mahasiswas', 'nilai_mahasiswas.nim', '=', 'mahasiswas.nim')
            ->where('nilai_mahasiswas.kelompok_id', $id)
            ->where('nilai_mahasiswas.deleted_at', null)
            ->select('nilai_mahasiswas.*')
            ->get();

        // convert to eloquent
        $assessmentStudents = NilaiMahasiswa::hydrate($assessmentStudents->toArray())->load('detail_nilai_mahasiswa.komponen_nilai','detail_nilai_mahasiswa.nilai_mahasiswa.poin_penilaian', 'detail_nilai_mahasiswa.nilai_mahasiswa.mahasiswa',  'poin_penilaian.komponen_penilaian', 'kelompok', 'mahasiswa.user');
        return ResponseFormatter::success(
            new AssessmentStudentCollection($assessmentStudents),
            'Data berhasil diambil'
        );
    }

    public function store(Request $request, $id){
        $dosen = User::find(auth()->user()->id)->dosen;
        // find kelompok by id
        $kelompok = Kelompok::find($id);
        if(!$kelompok){
            return ResponseFormatter::error(
                null,
                'Data Kelompok tidak ada',
                404
            );
        }

        // get role_dosen_kelompok_id
        $roleDosenKelompok = DB::table('role_kelompoks')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->where('role_kelompoks.nidn', $dosen->nidn)
            ->where('role_kelompoks.kelompok_id', $id)
            ->where('role_kelompoks.deleted_at', null)
            ->select('role_kelompoks.*', 'kategori_roles.nama as kategori')
            ->first();

        // check if role_dosen_kelompok_id is penguji or pembimbing
        $roleDosenKelompok =  RoleKelompok::find($roleDosenKelompok->id)->load('role_group');
        $assessmentStudents = json_decode($request->assessmentStudents);
        foreach($assessmentStudents as $assessment){
            $check = DB::table('nilai_mahasiswas')
                ->join('detail_nilai_mahasiswas', 'nilai_mahasiswas.id', '=', 'detail_nilai_mahasiswas.nilai_id')
                ->where('nilai_mahasiswas.kelompok_id', $assessment->kelompok->id)
                ->where('nilai_mahasiswas.poin_penilaian_id', $id)
                ->where('nilai_mahasiswas.role_dosen_kelompok_id', $roleDosenKelompok->id)
                ->select('detail_nilai_mahasiswas.*')
                ->first();

            $role_not_main =  $roleDosenKelompok->role_group->role_kategori->role_group->where('id','!=',$roleDosenKelompok->role_group->id)->where('is_main',0);
            if ($role_not_main->count() > 0) {
                $bobot_not_main = 0;
                foreach ($role_not_main as $rnm) {
                    if ($rnm->role_kelompok->where('kelompok_id',$kelompok->id)->count() < 1) {
                        $bobot_not_main += $rnm->role_group_penilaian->where('poin_penilaian_id', $assessment->assessmentPoint->id)->sum('bobot');
                    }
                }
            }

            // if not exist, start create
            $finalValue = 0;
            if(!$check){
                $nilaiMahasiswa = NilaiMahasiswa::create([
                    'poin_penilaian_id' => $assessment->assessmentPoint->id,
                    'kelompok_id' => $assessment->kelompok->id,
                    'role_dosen_kelompok_id' => $roleDosenKelompok->id,
                    'nim' => $assessment->mahasiswa->nim,
                    'nilai' => 0,
                    'approved_status' => false
                ]);

                // dd($detailAssessmentStudents);
                foreach($assessment->detailAssessmentStudent as $detailAssessmentStudent){
                    $detailNilaiMahasiswa = new DetailNilaiMahasiswa();
                    $detailNilaiMahasiswa->nilai_id = $nilaiMahasiswa->id;
                    $detailNilaiMahasiswa->komponen_id = $detailAssessmentStudent->assessmentComponent->id;
                    $detailNilaiMahasiswa->nilai = $detailAssessmentStudent->score;
                    $detailNilaiMahasiswa->save();
                    $finalValue += $detailAssessmentStudent->score;
                }

                // update nilai mahasiswa
                $nilaiMahasiswa->nilai = $finalValue;
                $nilaiMahasiswa->save();
            } else {
                // if exist, start update
                $nilaiMahasiswa = NilaiMahasiswa::find($check->nilai_id);
                $nilaiMahasiswa->nilai = 0;
                $nilaiMahasiswa->save();

                foreach($request->assessmentStudents->detailAssessmentStudent as $detailAssessmentStudent){
                    $detailNilaiMahasiswa = DetailNilaiMahasiswa::find($detailAssessmentStudent->id);
                    $detailNilaiMahasiswa->nilai = $detailAssessmentStudent->score;
                    $detailNilaiMahasiswa->save();
                    $finalValue += $detailAssessmentStudent->score;
                }
            }
            $bobot_role =  $roleDosenKelompok->role_group->role_group_penilaian->where('poin_penilaian_id', $assessment->assessmentPoint->id)->first()->bobot;
            try {
                if (isset($bobot_not_main)) {
                    $bobot_role += $bobot_not_main;
                }
            } catch (\Throwable $th) {
               return $th;
            }
            // update nilai mahasiswa
            $nilaiMahasiswa->nilai = $finalValue * ($bobot_role / 100);
            $nilaiMahasiswa->save();
        }
        return ResponseFormatter::success(
            null,
            'Data berhasil ditambahkan'
        );
    }
}
