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
use Illuminate\Support\Facades\Gate;


class NilaiMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Kelompok $kelompok, RoleKelompok $role, PoinPenilaian $penilaian)
    {
        // return Auth::user()->dosen->role_kelompok->pluck('role_group_id'); 
        // return  $penilaian->role_group_penilaian->pluck('role_group_id');
        // .'--'.Auth::user()->dosen->nidn;
        // return "oke";
        $user = Auth::user();   
        // return $user->dosen->role_kelompok->where('kelompok_id', $kelompok->id)->join('role_group_kelompoks', 'role_kelompoks.role_group_id', 'role_group_kelompoks.id')->select('role_group_kelompoks.*')->get();
        // return $user->dosen->role_kelompok_group->where('kelompok_id', $kelompok->id);
        // return $penilaian->role_group_penilaian;
        // return $penilaian->role_group_penilaian->pluck('role_group_id')->toArray();
        // return $user->dosen->role_kelompok->pluck('role_group_id')->toArray();
        // $check =  array_intersect($user->dosen->role_kelompok->pluck('role_group_id')->toArray(), $penilaian->role_group_penilaian->pluck('role_group_id')->toArray());
        // return $check;
        // if (!empty($check)) {
        //     return "ada yang sama";
        // }else{
        //     return "beda";
        // }

        if (Auth::user()->hasRole('dosen')) {
            if (!Gate::check('role_penilaian_allowed', $role)) {
                return back();
            }
        }else{
            return back();
        }


        if (Auth::user()->hasRole('dosen')) {
            if (!Gate::check('role_penilaian_detail_allowed', [$kelompok, $penilaian])) {
                return back();
            }
        }else{
            return back();
        }
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

        if ($nilai_mahasiswa_kelompok->count() < 1) {
            return back()->with('error','Anda belum menginput nilai');
        }

        $nilai_mahasiswa_kelompok->update([
            'approved_status' => true
        ]);

        return back()->with('success','Seluruh nilai telah berhasil diapprove');   
    }

    public function update_status_koordinator(Request $request, Kelompok $kelompok, PoinPenilaian $penilaian)
    {
        $role = RoleKelompok::where('role_group_id', $request->role_group_id)->where('kelompok_id',$kelompok->id)->first();

        if($role == NULL){
            return back()->with('error', 'Kelompok '.$kelompok->nama_kelompok.' tidak memiliki role tersebut');
        }

        $nilai_mahasiswa_kelompok = NilaiMahasiswa::where('kelompok_id',$kelompok->id)
                                                ->where('role_dosen_kelompok_id',$role->id)
                                                ->where('poin_penilaian_id',$penilaian->id);

            $nilai_mahasiswa_kelompok->update([
                'approved_status' => false
            ]);

            return back()->with('success','Seluruh nilai telah berhasil diunapprove');   

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

       $role_not_main =  $role->role_group->role_kategori->role_group->where('id','!=',$role->role_group->id)->where('is_main',0);

       if ($role_not_main->count() > 0) {
            $bobot_not_main = 0;
            foreach ($role_not_main as $rnm) {
                if ($rnm->role_kelompok->where('kelompok_id',$kelompok->id)->count() < 1) {
                    $bobot_not_main += $rnm->role_group_penilaian->where('poin_penilaian_id', $penilaian->id)->sum('bobot');
                }
            }
       }

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
