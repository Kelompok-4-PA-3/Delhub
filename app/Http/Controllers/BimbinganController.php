<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Reference;
use Illuminate\Http\Request;
use App\Models\Request as Bimbingan;
use App\Notifications\RequestNotification;
use App\Notifications\UpdateRequestNotification;

class BimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'kelompok_id' => 'required',
            'description' => 'required',
            'waktu' => 'required',
            'ruangan_id' => 'required',
            'status' => 'nullable',
        ];

        $ref = Reference::where('kategori', '=', 'status_bimbingan_default')->first();
        // return $ref;
        $validasi = $request->validate($data);
        $bimbingan = new Bimbingan();
        $validasi['status'] = 'waiting';

        $bimbingan->create([
            'kelompok_id' => $validasi['kelompok_id'],
            'description' => $validasi['description'],
            'waktu' => $validasi['waktu'],
            'ruangan_id' => $validasi['ruangan_id'],
            'status' => $ref->id,
        ]);

        $kelompok = Kelompok::find($validasi['kelompok_id']);
        $dosen = $kelompok->dosen->user;

        // send email to dosen
        $dosen->notify(new RequestNotification($kelompok));
        return redirect()->back()->with('success', 'Request bimbingan telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function update_status($status, $id)
    {
        $bimbingan = Bimbingan::find($id);
        $bimbingan->status = $status;
        $bimbingan->save();

        // send email to mahasiswa
        $kelompok = $bimbingan->kelompok;
        $mahasiswa = $kelompok->kelompok_mahasiswa;
        foreach ($mahasiswa as $mhs) {
            $mhs->user->notify(new UpdateRequestNotification($status));
        }

        return redirect()->back()->with('success', 'Request bimbingan telah di' . $status);
    }

    public function show(Bimbingan $bimbingan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bimbingan $bimbingan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bimbingan $bimbingan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bimbingan $bimbingan)
    {
        //
    }
}
