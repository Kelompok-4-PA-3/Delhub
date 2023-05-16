<?php

namespace App\Http\Controllers;

use App\Models\NilaiMahasiswaRole;
use App\Models\Kelompok;
use App\Models\RoleKelompok;
use App\Models\RoleGroupKelompok;
use App\Models\RoleKelompokPenilaian;
use App\Models\DetailNilaiMahasiswaRole;
use Illuminate\Http\Request;

class NilaiMahasiswaRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Kelompok $kelompok, RoleKelompok $role, RoleGroupKelompok $roleGroup)
    {
        return view('dashboard.penilaian.detail_role',[
            'kelompok' => $kelompok,
            'roleGroup' => $roleGroup,
            'role_dosen' => $role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if ($request->ajax()) {
            // return NilaiMahasiswaRole::latest()->get();
            // response()->json(['success'=>true]);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Kelompok $kelompok, RoleKelompok $role, RoleGroupKelompok $roleGroup)
    {

        if ($request->ajax()) {
        //    return $request;
            // return $request.'kelompok : '.$kelompok.'role : '.$role.'RoleGroup : '.$roleGroup;
            $data = [];
            // $komponen = $roleGroup->komponen_penilaian;
            // return $komponen;
            // foreach($komponen as $pkp){
            // $data['komponen'.$rolePenilaian->id] = 'required';
            // }
            // return $data;
            // return  $rolePenilaian;

            // return "manatap";
            // return $data;
            // $validasi = $request->validate($data);?
            // $nilai = ''.$rolePenilaian->id;
            // return $$nilai;
            // return $request->komponen.$rolePenilaian->id;
            $komponen_nilai = RoleKelompokPenilaian::where('id',  $request->pk)->first();
            $total = 0;
            // return $komponen;
            // $komponen = "".$request->pk;
            // return $$komponen;
            // $total = $request->komponen;
            // return  $request->value;
            $request->value *= ( $komponen_nilai->bobot / 100 );
            // }

            // return  $request->value;
     
            $nilai = new NilaiMahasiswaRole;

            $old_nilai = NilaiMahasiswaRole::where('nim',$request->mahasiswa)
                                            ->where('role_kelompok_id',$role->id)
                                            ->where('kelompok_id',$kelompok->id)
                                            ->first();            // return "success";

            if ($old_nilai != NULL){
              $nilai = NilaiMahasiswaRole::find($old_nilai->id);
            }
            // return "success";

            $nilai->kelompok_id = $kelompok->id;
            $nilai->role_kelompok_id = $role->id;
            $nilai->nim = $request->mahasiswa;
            $nilai->nilai = 0;
            $nilai->save();
            // $request->value;

            // $cek_detail_nilai = DetailNilaiMahasiswaRole::where('nilai_id', $nilai->id)->get();
            // return $nilai->nilai;
            // return "success";
     
            // foreach($komponen as $pkp){
            // return "success";
            
            // try {
            $old_komponen = DetailNilaiMahasiswaRole::where('nilai_role_id',$nilai->id)->where('komponen_role_penilaian_id',$request->pk)->first();
            // } catch (\Throwable $th) {
                // return $th;
            // }
            // return "success";

            $detail_nilai = new DetailNilaiMahasiswaRole;
            // return "success";

            if ($old_komponen != NULL) {    
                 $detail_nilai = DetailNilaiMahasiswaRole::find($old_komponen->id);
            }
            // return $detail_nilai;
            try {
                $detail_nilai->nilai_role_id = $nilai->id;
                $detail_nilai->komponen_role_penilaian_id = $request->pk;
                $detail_nilai->nilai =  $request->value;
                $detail_nilai->save();

                $total_nilai = 0;
                $komponen_nilai = DetailNilaiMahasiswaRole::where('nilai_role_id',$nilai->id)->get();
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

            
            $nilai->nilai = $total_nilai;
            $nilai->save();
            // }
     
            // return back()->with('success','Nilai mahasiswa berhasil ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NilaiMahasiswaRole $nilaiMahasiswaRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiMahasiswaRole $nilaiMahasiswaRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NilaiMahasiswaRole $nilaiMahasiswaRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiMahasiswaRole $nilaiMahasiswaRole)
    {
        //
    }
}
