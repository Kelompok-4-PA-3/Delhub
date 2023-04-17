<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\KelompokMahasiswa;
use App\Models\Ruangan;
use App\Models\Dosen;
use App\Models\KrsUser;
use App\Models\Reference;
use App\Models\Regulasi;
use App\Models\PembimbingPenguji;
use App\Models\Pembimbing;
use App\Models\Penguji;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function people($id)
    {
        $kelompok = Kelompok::where('id',$id)->first();
        $mahasiswa = KrsUser::where('krs_id',$kelompok->krs_id)->get();
        $anggota = KelompokMahasiswa::where('kelompok_id',$kelompok->id)->get();
        $role_kelompok = Reference::where('kategori', '=', 'role_kelompok')->get();

        return view('dashboard.kelompok.index',[
            'title' => 'Kelompok',
            'kelompok' => $kelompok,
            'anggota' => $anggota,
            'mahasiswa' => $mahasiswa,
            'role_kelompok' => $role_kelompok,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'jumlah_kelompok' => 'required|numeric',
            'krs_name' => 'required',
            'krs_id' => 'required',
        ];
        $validasi = $request->validate($data);
        $jlh_kelompok = Kelompok::where('krs_id','=', $request->krs_id)->get();
        if ($jlh_kelompok->count() > 0) {
            $kelompok = new Kelompok();
            for ($i=$jlh_kelompok->count() + 1; $i <= $jlh_kelompok->count() + (int)$request->jumlah_kelompok; $i++) {
                $kelompok->create([
                    'nama_kelompok' => 'KELOMPOK-'.$i.'-'.$request->krs_name,
                    'krs_id' => $request->krs_id
                ]);
            }
            return redirect()->back()->with('success', 'Kelompok telah berhasil dibuat');
        }else{
            $kelompok = new Kelompok();
            for ($i=1; $i <= $request->jumlah_kelompok ; $i++) {
                $kelompok->create([
                    'nama_kelompok' => 'KELOMPOK-'.$i.'-'.$request->krs_name,
                    'krs_id' => $request->krs_id
                ]);
            }
            return redirect()->back()->with('success', 'Kelompok telah berhasil dibuat');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Kelompok $kelompok)
    {
        $ruangan = Ruangan::latest()->get();
        $dosen = Dosen::latest()->get();
        $reference = Reference::where('kategori','=','kelompok')->get();
        $pembimbing_penguji = PembimbingPenguji::where('kelompok_id','=',$kelompok->id)->get();
        $pembimbing = PembimbingPenguji::where('kelompok_id','=',$kelompok->id)->get();
        $role_dosen = Reference::where('kategori', '=', 'role_dosen')->get();
        $pembimbing = PembimbingPenguji::where('kelompok_id','=',$kelompok->id)
        ->leftjoin('references', function($ref){
            $ref->on('pembimbing_pengujis.reference_id', '=', 'references.id')
            ->where('value', '=', 'pembimbing');
        })->leftjoin('dosens', function($dosen){
            $dosen->on('pembimbing_pengujis.dosen_id', '=', 'dosens.nidn')
            ->leftJoin('users', 'dosens.user_id', '=', 'users.id');
        })->get(['pembimbing_pengujis.id','users.nama']);
        $status_bimbingan = Reference::where('kategori', '=', 'status_bimbingan')->get();
        $regulasi = Regulasi::where('krs_id', '=', $kelompok->krs_id)->first();
        // return $regulasi->selec('');

        return view('dashboard.kelompok.kelompok',[
            'title' => $kelompok->nama_kelompok,
            'kelompok' => $kelompok,
            'reference' => $reference,
            'dosen' => $dosen,
            'ruangan' => $ruangan,
            'pembimbing' => $pembimbing,
            'role_dosen' => $role_dosen,
            'status_bimbingan' => $status_bimbingan,
            'regulasi' => $regulasi,
        ]);
        // return $kelompok;
    }

    public function add_pembimbing(Request $request){
        // return $request;
        $data = [
            'kelompok_id' => 'required',
            'pembimbing_1' => 'required',
            'pembimbing_2' => 'nullable',
        ];

        $validasi = $request->validate($data);
        $data_pembimbing = Pembimbing::where('kelompok_id',$request->kelompok_id)->first();
        $pembimbing = new Pembimbing();

        if ($data_pembimbing != NULL) {
            $pembimbing = $data_pembimbing;
            // return 'ya';
        }
       
        $pembimbing->kelompok_id = $validasi['kelompok_id'];
        $pembimbing->pembimbing_1 = $validasi['pembimbing_1'];
        $pembimbing->pembimbing_2 = $validasi['pembimbing_2'];
        $pembimbing->save();

        return back()->with('success','Pembimbing telah berhasil ditambahkan ke kelompok ini');
    }

    public function delete_pembimbing($id){
        // return $id;
        Pembimbing::find($id)->delete();

        return back()->with('success','Pembimbing telah berhasil dihapus');
    }

    public function add_penguji(Request $request){
        // return $request;
        $data = [
            'kelompok_id' => 'required',
            'penguji_1' => 'required',
            'penguji_2' => 'nullable',
        ];

        $validasi = $request->validate($data);
        $data_penguji = Penguji::where('kelompok_id',$request->kelompok_id)->first();
        $penguji = new Penguji();

        if ($data_penguji != NULL) {
            $penguji = $data_penguji;
            // return 'ya';
        }
       
        $penguji->kelompok_id = $validasi['kelompok_id'];
        $penguji->penguji_1 = $validasi['penguji_1'];
        $penguji->penguji_2 = $validasi['penguji_2'];
        $penguji->save();

        return back()->with('success','Penguji telah berhasil ditambahkan ke kelompok ini')->with('penguji','active');
    }

    public function delete_penguji($id){
        // return $id;
        Penguji::find($id)->delete();

        return back()->with('success','Penguji telah berhasil dihapus');
    }


    public function add_mahasiswa(Request $request){
        // return $request;
        $data = [
            'role' => 'required',
            'kelompok' => 'required',
            'mahasiswa' => 'required',
        ];


        $validasi = $request->validate($data);

        KelompokMahasiswa::create([
            'kelompok_id' => $validasi['kelompok'],
            'nim' => $validasi['mahasiswa'],
            'role' => $validasi['role'],
        ]);

        return back()->with('success','Mahasiswa telah berhasil ditambahkan ke kelompok ini');
    }

    public function delete_mahasiswa(Request $request){
        // return $request;
        $data = [
            'mahasiswa' => 'required',
            'kelompok' => 'required',
        ];

        $validasi = $request->validate($data);

        KelompokMahasiswa::where('nim',$request->mahasiswa)->where('kelompok_id',$request->kelompok)->delete();

        return back()->with('success','Mahasiswa telah berhasil dikeluarkan dari kelompok ini');
    }


    public function add_topik(Request $request){
        $data = [
            'topik' => 'required',
            'kelompok' => 'required'
        ];

        $validasi = $request->validate($data);

        $kelompok = Kelompok::find($request->kelompok);
        $kelompok->topik = $validasi['topik'];
        $kelompok->save();

        return back()->with('success', 'Topik telah berhasil dibuat');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelompok $kelompok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelompok $kelompok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelompok $kelompok)
    {
        //
    }
}
