<?php

namespace App\Http\Controllers;

use App\Models\NilaiMahasiswa;
use App\Models\DetailNilaiMahasiswa;
use App\Models\KomponenPenilaian;
use App\Models\Kelompok;
use App\Models\PoinPenilaian;
use App\Models\RoleKelompok;
use App\Models\Mahasiswa;
use Auth;
use Illuminate\Http\Request;

class NilaiMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Kelompok $kelompok, RoleKelompok $role, PoinPenilaian $penilaian)
    {
        // return $role;
        return view('dashboard.penilaian.detail',[
            'kelompok' => $kelompok,
            'penilaian' => $penilaian,
            'role_dosen' => $role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update_status(Request $request, Kelompok $kelompok, RoleKelompok $role, PoinPenilaian $penilaian)
    {
        $nilai_mahasiswa_kelompok = NilaiMahasiswa::where('kelompok_id',$kelompok->id)
                                                ->where('role_dosen_kelompok_id',$role->id)
                                                ->where('poin_penilaian_id',$penilaian->id);

        if ($request->unapproved) {
            $nilai_mahasiswa_kelompok->update([
                'approved_status' => false
            ]);

            return back()->with('success','Seluruh nilai telah berhasil diunapprove');   

        }
        $nilai_mahasiswa_kelompok->update([
            'approved_status' => true
        ]);
                                                // ->get();
        return back()->with('success','Seluruh nilai telah berhasil diapprove');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Kelompok $kelompok, RoleKelompok $role, PoinPenilaian $penilaian, Mahasiswa $mahasiswa)
    {
       $data = [];

       $komponen_nilai = KomponenPenilaian::where('id',  $request->pk)->first();
       $total = 0;

       $request->value *= ( $komponen_nilai->bobot / 100 );

       $nilai = new NilaiMahasiswa;

       $old_nilai = NilaiMahasiswa::where('nim',$request->mahasiswa)
                                       ->where('role_dosen_kelompok_id',$role->id)
                                       ->where('poin_penilaian_id',$penilaian->id)
                                       ->where('kelompok_id',$kelompok->id)
                                       ->first();   
                                       
       if ($old_nilai != NULL){
            $nilai = NilaiMahasiswa::find($old_nilai->id);
       }    
    //    return $role->role_group->id;
       $role_not_main =  $role->role_group->role_kategori->role_group->where('id','!=',$role->role_group->id)->where('is_main',0);
    //    return $role_not_main;
    // return $role_not_main->role_kelompok->count() < 1 ? 'ya' : 'tidak';
    // return $role->role_group->role_kelompok;
       if ($role_not_main->count() > 0) {
            $bobot_not_main = 0;
            foreach ($role_not_main as $rnm) {
                if ($rnm->role_kelompok->where('kelompok_id',$kelompok->id)->count() < 1) {
                    $bobot_not_main += $rnm->role_group_penilaian->sum('bobot');

                    // if ($rnm->role_kelompok->where('kelompok_id',$kelompok->id)->count() < 1) {
                    //     $bobot_not_main += $rnm->role_group_penilaian->sum('bobot');
                    // }
                }
            }
       }

    //    return $bobot_not_main;

       $nilai->kelompok_id = $kelompok->id;
       $nilai->role_dosen_kelompok_id = $role->id;
       $nilai->poin_penilaian_id = $penilaian->id;
       $nilai->nim = $request->mahasiswa;
       $nilai->approved_status = false;
       $nilai->nilai = 0;
       $nilai->save();

       $old_komponen = DetailNilaiMahasiswa::where('nilai_id',$nilai->id)
                                            ->where('komponen_id',$request->pk)
                                            ->first();

       $detail_nilai = new DetailNilaiMahasiswa;

       if ($old_komponen != NULL) {    
            $detail_nilai = DetailNilaiMahasiswa::find($old_komponen->id);
       }

       try {
            $detail_nilai->nilai_id = $nilai->id;
            $detail_nilai->komponen_id = $request->pk;
            $detail_nilai->nilai =  $request->value;
            $detail_nilai->save();

            $total_nilai = 0;
            $komponen_nilai = DetailNilaiMahasiswa::where('nilai_id',$nilai->id)->get();
            foreach ($komponen_nilai as $kn) {
                $total_nilai +=  $kn->nilai;
            }
        } catch (\Throwable $th) {
            return $th;
        }
        $bobot_role =  $role->role_group->role_group_penilaian->where('poin_penilaian_id',$penilaian->id)->first()->bobot;
        try {
            if (isset($bobot_not_main)) {
                $bobot_role += $bobot_not_main;
            }
        } catch (\Throwable $th) {
           return $th;
        }
        // if ($role) {
        //     # code...
        // }
        $nilai->nilai = $total_nilai * ($bobot_role / 100);
        $nilai->save();

        return $nilai.'-'.$bobot_role.'--'.$detail_nilai;

    }

    /**
     * Display the specified resource.
     */
    public function show(NilaiMahasiswa $nilaiMahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiMahasiswa $nilaiMahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NilaiMahasiswa $nilaiMahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiMahasiswa $nilaiMahasiswa)
    {
        //
    }
}
