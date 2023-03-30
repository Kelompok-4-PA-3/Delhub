<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\User;
use App\Models\KrsUser;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use Spatie\Permission\Models\Role;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        
        $role = auth()->user()->getRoleNames()->toArray();
        $krs = Krs::latest()->get();
        // return $role;

        // di KRS harus ada user id jadi semua data krs yang terikat ke krs yang akan dipanggil

        // if(in_array('Dosen', $role)){
        //     return "iya dosen";
        // }else if(in_array('Mahasiswa', $role)){
        //     return 'bukan dosen';
        // }else{
        //     return 'bukan dosen';
        // }

        // return auth()->user()->getRoleNames();
        // user;
        // ->roles;
        // return $user->dosen;
        // if($user->dosen > 0)
        // $krs = Krs::where('dosen_ml', $id)->get();
        // return $krs;
        return view('dashboard.index',[
            'title' => 'Dashboardss',
            'krs' => $krs,
        ]);
    }

    public function show($id){
        // return $id;
       $krs = Krs::where('id', $id)->first();
       $mahasiswa = Mahasiswa::latest()->get();
       $kelompok = Kelompok::where('krs_id',$id)->orderBy('created_at')->get();

       return view('dashboard.detail',[
        'title' => $krs->kategori->nama_mk,
        'krs' => $krs,
        'kelompok' => $kelompok,
        'mahasiswa' => $mahasiswa
       ]);
       return view('dashboard.detail');
    }

    public function add_user(Request $request){

        $data = [
            'mahasiswa' => 'required'
        ];

        $validasi = $request->validate($data);
        // $krs_user = new KrsUser();
        foreach($request->mahasiswa as $m){
            KrsUser::create([
                'user_id' => $m,
                'krs_id' => $request->krs_id,
            ]);
        }

        return back()->with('success','Mahasiswa berhasil ditambahkan ke proyek ini');
    }

}
