<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Reference;
use Illuminate\Http\Request;
use App\Models\Request as Bimbingan;
use App\Notifications\RequestNotification;
use App\Notifications\UpdateRequestNotification;
use Storage;

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

    public function upload_bukti(Request $request, $id)
    {
        $data = [
            'hasil' => 'required'
        ];

        $validasi = $request->validate($data);
        $bimbingan = Bimbingan::find($id);

        // if ($request->file('file-bukti')) {

        //     $filename = $request->file('file-bukti')->getClientOriginalName();
        //     $path = $request->file('file-bukti')->storeAs('public/bukti-bimbingan/', $filename);
        //     $bimbingan->file_bukti = $filename;
        //     $bimbingan->save();

        //     return redirect()->back()->with('success', 'Bukti bimbingan telah berhasil diupload');
        // }
        $bimbingan->hasil = $validasi['hasil'];
        $bimbingan->save();

        return back()->with('failed', 'Permintaan anda gagal di proses');
        // ->file('file-bukti');
    }

    public function approve_bukti(Request $request, $id)
    {
        $bimbingan = Bimbingan::find($id);
        $bimbingan->is_done = true;
        $bimbingan->save();

        return redirect()->back()->with('success', 'Bukti bimbingan telah berhasil diapprove');
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

        $bimbingan = Bimbingan::create([
            'kelompok_id' => $validasi['kelompok_id'],
            'description' => $validasi['description'],
            'waktu' => $validasi['waktu'],
            'ruangan_id' => $validasi['ruangan_id'],
            'status' => $ref->id,
        ]);

        $kelompok = Kelompok::find($validasi['kelompok_id']);
        $pembimbings = $kelompok->pembimbings;
        foreach ($pembimbings as $pembimbing) {
            $pembimbing->user->notify(new RequestNotification($bimbingan, $kelompok));
        }
        $tokens = $pembimbings->pluck('user.firebase_token')->toArray();
        // if tokens is empty, don't send push notification
        if (!empty($tokens)){
            sendPushNotification('Permintaan Bimbingan', 'Anda mendapatkan permintaan bimbingan baru dari ' . $kelompok->nama_kelompok, $tokens, $bimbingan);
        }
        return redirect()->back()->with('success', 'Request bimbingan telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function update_status($status, $id)
    {
        $bimbingan = Bimbingan::find($id);
        $bimbingan->status = $status;
        // return $bimbingan->reference->value;
        $bimbingan->save();
        $ref = Reference::find($status);

        // send email to mahasiswa
        $kelompok = $bimbingan->kelompok;
        // get all mahasiswa in kelompok mahasiswa
        $mahasiswa = $kelompok->kelompok_mahasiswa;
        foreach ($mahasiswa as $mhs) {
            $mhs->mahasiswa->user->notify(new UpdateRequestNotification(
                $bimbingan,
                $ref->value,
            ));
        }

        $tokens = $mahasiswa->pluck('mahasiswa.user.firebase_token')->toArray();
        // if tokens is empty, don't send push notification
        if (!empty($tokens)){
            sendPushNotification('Status Bimbingan', 'Status bimbingan kelompok anda di-' . $ref->value, $tokens, $bimbingan);
        }
        return redirect()->back()->with('success', 'Request bimbingan telah di' . $ref->value);
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
