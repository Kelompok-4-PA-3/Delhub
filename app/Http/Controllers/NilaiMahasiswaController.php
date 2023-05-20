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
    public function update_status(Request $request, Kelompok $kelompok, RoleKelompok $role)
    {
    // return $role;
        $data = ['approved_status'];
        $validasi  = $request->validate($data);
        $nilai_mahasiswa_kelompok = NilaiMahasiswa::where('kelompok_id',$kelompok->id)
                                                ->where('role_dosen_kelompok_id',$role->id);
        $nilai_mahasiswa_kelompok->update([
            'approved_status' => $request->approved_status
        ]);
                                                // ->get();
        return back()->with('success','Seluruh nilai telah berhasil diapprove');   
        // $kelompok.$role;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Kelompok $kelompok, RoleKelompok $role, PoinPenilaian $penilaian, Mahasiswa $mahasiswa)
    {
        // return $request;
       $data = [];

       $komponen_nilai = KomponenPenilaian::where('id',  $request->pk)->first();
       $total = 0;

    //    $komponen = $penilaian->komponen_penilaian;
    //    foreach($komponen as $pkp){
    //         $data['komponen'.$pkp->id] = 'required';
    //    }

    //    $validasi = $request->validate($data);
    //    $total = 0;
    //    foreach($komponen as $pkp){
    //         $total += $validasi['komponen'.$pkp->id] * ($pkp->bobot / 100);
    //    }

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

       $nilai->kelompok_id = $kelompok->id;
       $nilai->role_dosen_kelompok_id = $role->id;
       $nilai->poin_penilaian_id = $penilaian->id;
       $nilai->nim = $request->mahasiswa;
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
            // return $komponen_nilai;
            foreach ($komponen_nilai as $kn) {
                // return $kn->komponen_role_penilaian->bobot;
                $total_nilai +=  $kn->nilai;
                // * ($kn->komponen_role_penilaian->bobot / 100);
            }

        // return $total_nilai;
        } catch (\Throwable $th) {
            return $th;
        }
        $bobot_role =  $role->role_group->role_group_penilaian->where('poin_penilaian_id',$penilaian->id)->first();
        $nilai->nilai = $total_nilai * ($bobot_role->bobot / 100);
        $nilai->save();

        return $nilai;










       // lama

    //    $nilai = new NilaiMahasiswa;
    //    $old_nilai = NilaiMahasiswa::where('nim',$mahasiswa->nim)->where('poin_penilaian_id',$penilaian->id)->where('role_dosen_kelompok_id',$role->id)->where('kelompok_id',$kelompok->id)->first();
    //    if ($old_nilai != NULL){
    //      $nilai = NilaiMahasiswa::find($old_nilai->id);
    //    }
    //    $nilai->kelompok_id = $kelompok->id;
    //    $nilai->poin_penilaian_id = $penilaian->id;
    //    $nilai->role_dosen_kelompok_id = $role->id;
    // //    Auth;
    //    $nilai->nim = $mahasiswa->nim;
    //    $nilai->nilai = $total;
    //    $nilai->save();

    //    foreach($komponen as $pkp){
    //        $old_komponen = DetailNilaiMahasiswa::where('nilai_id',$nilai->id)->where('komponen_id',$pkp->id)->first();
    //        $detail_nilai = new DetailNilaiMahasiswa;
    //        if ($old_komponen != NULL) {
    //             $detail_nilai = DetailNilaiMahasiswa::find($old_komponen->id);
    //        }
    //        $detail_nilai->nilai_id = $nilai->id;
    //        $detail_nilai->komponen_id = $pkp->id;
    //        $detail_nilai->nilai = $validasi['komponen'.$pkp->id];
    //        $detail_nilai->save();
    //    }

    //    return back()->with('success','Nilai mahasiswa berhasil ditambahkan');

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
