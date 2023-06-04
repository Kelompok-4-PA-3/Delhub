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
    $jadwals = Jadwal::all(); // Ambil semua data jadwal dari model Jadwal

    return view('jadwal.index', compact('jadwals'));
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
    $validatedData = $request->validate([
        'nama_jadwal' => 'required',
        'url' => 'required|url',
    ]);

    $jadwal = new Jadwal();
    $jadwal->nama_jadwal = $request->input('nama_jadwal');
    $jadwal->url = $request->input('url');
    $jadwal->save();

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
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


public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'nama_jadwal' => 'required',
        'url' => 'required|url',
    ]);

    $jadwal = Jadwal::findOrFail($id);
    $jadwal->nama_jadwal = $request->input('nama_jadwal');
    $jadwal->url = $request->input('url');
    $jadwal->save();

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
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