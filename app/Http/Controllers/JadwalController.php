<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelompok;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all jadwals from the Jadwal table
        $jadwals = Jadwal::all();
        $kelompoks = Kelompok::all();
        $ruangans = Ruangan::all();
        return view('jadwal.index', compact('jadwals', 'kelompoks', 'ruangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jadwals = Jadwal::all();
        return view('jadwal.create', compact('jadwals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'kel' => 'required',
        //     'tanggal' => 'required',
        //     'waktu' =>'required',
        //     'ruangan' => 'required',
        // ]);

        // $jadwal = new Jadwal();
        // $jadwal->kel = $validatedData['kel'];
        // $jadwal->tanggal = $validatedData['tanggal'];
        // $jadwal->waktu = $validatedData['waktu'];
        // $jadwal->ruangan = $validatedData['ruangan'];
        // $jadwal->save();

        // return redirect()->route('jadwal.index')
        //     ->with('success', 'Jadwal created successfully.');

        $data = [
            'id_kel' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'ruangan_id' => 'required',
        ];

        $validasi = $request->validate($data);

        // $jadwal = Jadwal::create([
        //     'id_kel' => $validasi['id_kel'],
        //     'tanggal' => $validasi['tanggal'],
        //     'waktu' => $validasi['waktu'],
        //     'ruangan_id' => $validasi['ruangan_id'],
        // ]);

        Jadwal::create($validasi);

        return redirect('/jadwal')->back()->with('success', 'Request bimbingan telah berhasil dibuat');
    }

    public function publish(Request $request)
    {

        $data = [
            'id_kel' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'ruangan_id' => 'required',
            'publish' => 'required                                                                       '
        ];

        $validasi = $request->validate($data);


        Jadwal::create($validasi);

        return redirect('/jadwal')->back()->with('success', 'Request bimbingan telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validatedData = $request->validate([
            'kel' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'ruangan' => 'required',
        ]);

        $jadwal->kel = $validatedData['kel'];
        $jadwal->tanggal = $validatedData['tanggal'];
        $jadwal->waktu = $validatedData['waktu'];
        $jadwal->ruangan = $validatedData['ruangan'];
        $jadwal->save();

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal deleted successfully.');
    }
}
