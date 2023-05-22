<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Request;
use App\Models\Kelompok;
use App\Models\Reference;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Resources\RequestResource;
use App\Http\Resources\RequestCollection;
use App\Notifications\RequestNotification;
use App\Notifications\UpdateRequestNotification;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('mahasiswa')) {
            $kelompok_id = User::find(auth()->user()->id)->mahasiswa->kelompok_mahasiswa->where('status', '1')->first()->kelompok->id ?? null;
            $requests = Request::where('kelompok_id', $kelompok_id)->with('ruangan', 'reference', 'kelompok')->orderBy('created_at', 'desc')->get();
            return ResponseFormatter::success(new RequestCollection($requests), 'Data berhasil diambil');
        } else if (auth()->user()->hasRole('dosen')) {
            $krs_id = $request->krs_id;
            $dosen = User::find(auth()->user()->id)->dosen->nidn;
            // get request where dosen is pembimbing
            $requests = Request::whereHas('kelompok', function ($query) use ($dosen) {
                $query->whereHas('pembimbings', function ($query) use ($dosen) {
                    $query->where('nidn', $dosen);
                });
            })->with('ruangan', 'reference', 'kelompok')->orderBy('created_at', 'desc')->get();
            return ResponseFormatter::success(new RequestCollection($requests), 'Data berhasil diambil');
        }
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();
        $ref = Reference::where('kategori', '=', 'status_bimbingan_default')->first();
        $data['status'] = $ref->id;
        $request = Request::create($data);

        $kelompok = Kelompok::find($data['kelompok_id']);
        $pembimbings = $kelompok->pembimbings;
        foreach ($pembimbings as $pembimbing) {
            $pembimbing->user->notify(new RequestNotification($request, $kelompok));
        }

        return ResponseFormatter::success(new RequestResource($request), 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $request = Request::find($id)->load('ruangan', 'reference', 'kelompok');
        return ResponseFormatter::success(new RequestResource($request), 'Data berhasil diambil');
    }

    public function update(UpdateRequest $request, $id)
    {
        $bimbingan = Request::find($id)->load('ruangan', 'reference', 'kelompok');
        $ref = Reference::where('value', $request->status)->first();
        $bimbingan->status = $ref->id;
        if ($request->waktu != null) {
            $bimbingan->waktu = $request->waktu;
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/files', $filename);
            $bimbingan->file_bukti = $filename;
            $bimbingan->is_done = 1;
        }
        $bimbingan->save();

        if (auth()->user()->hasRole('dosen')) {
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
        }

        return ResponseFormatter::success(new RequestResource($bimbingan), 'Data berhasil diubah');
    }
}
