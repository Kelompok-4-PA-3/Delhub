<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Ruangan;
use App\Models\Dosen;
use App\Models\Reference;
use App\Models\PembimbingPenguji;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function people($id)
    {   
        $kelompok = Kelompok::where('id',$id)->get();
        return view('dashboard.kelompok.index',[
            'title' => 'Kelompok',
            'Kelompok' => $kelompok
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
        // return $request;
        $data = [
            'jumlah_kelompok' => 'required|numeric',
            'krs_name' => 'required',
            'krs_id' => 'required',
        ];

        $validasi = $request->validate($data);
        $kelompok = new Kelompok();
        for ($i=1; $i <= $request->jumlah_kelompok ; $i++) { 
            $kelompok->create([
                'nama_kelompok' => 'KELOMPOK-'.$i.'-'.$request->krs_name,
                'krs_id' => $request->krs_id
            ]);
        }
        return redirect()->back()->with('success', 'Kelompok telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelompok $kelompok)
    {
        $ruangan = Ruangan::latest()->get();
        $dosen = Dosen::latest()->get();
        $reference = Reference::where('kategori','=','kelompok')->get();
        $pembimbing = PembimbingPenguji::where('kelompok_id','=',$kelompok->id)->get();
        // $pembimbing->reference()->where('kategori','=','kelompok')->where('value','=','pembimbing')->first();
        // return $pembimbing;
        // $bimbingan = Bimbingan::where('kelomp')
        // return $ruangan;
        return view('dashboard.kelompok.kelompok',[
            'title' => $kelompok->nama_kelompok,
            'kelompok' => $kelompok,
            'reference' => $reference,
            'dosen' => $dosen,
            'ruangan' => $ruangan,
            'pembimbing' => $pembimbing,
        ]);
        // return $kelompok;
    }

    public function add_pembimbing(Request $request){
        // return $request;
        $data = [
            'dosen' => 'required',
            'kelompok' => 'required',
            'reference' => 'required',
        ];

        $validasi = $request->validate($data);

        if($validasi['reference'] == 'pembimbing'){

            $kelompok = Kelompok::find($validasi['kelompok']);
            $kelompok->pembimbing = $validasi['dosen'];
            $kelompok->save();

            return back()->with('success','Pembimbing telah berhasil ditambahkan ke kelompok ini');
        }else{ 

            PembimbingPenguji::create([
                'dosen_id' => $request->dosen,
                'reference_id' => $request->reference,
                'kelompok_id' => $request->kelompok
            ]);

            return back()->with('success','Penguji telah berhasil ditambahkan ke kelompok ini');
        }
    }


    public function add_topik(Request $request){
        // return $request;
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
