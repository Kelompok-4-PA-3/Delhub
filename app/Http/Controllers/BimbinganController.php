<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Reference;
use Illuminate\Http\Request;
use App\Models\Request as Bimbingan;
use App\Notifications\RequestNotification;

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

       $validasi = $request->validate($data);
       $bimbingan = new Bimbingan();
       $validasi['status'] = 'waiting';
    //    return $validasi;
       $bimbingan->create([
        'kelompok_id' => $validasi['kelompok_id'],
        'description' => $validasi['description'],
        'waktu' => $validasi['waktu'],
        'ruangan_id' => $validasi['ruangan_id'],
        'status' => $validasi['status'],
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
