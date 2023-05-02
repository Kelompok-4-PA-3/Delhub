<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Request;
use App\Models\Kelompok;
use App\Models\Reference;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequest;
use App\Http\Resources\RequestCollection;
use App\Http\Resources\RequestResource;
use App\Notifications\RequestNotification;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('mahasiswa')) {
            $kelompok_id = User::find(auth()->user()->id)->mahasiswa->kelompok_mahasiswa->where('status', '1')->first()->kelompok->id ?? null;
            $requests = Request::where('kelompok_id', $kelompok_id)->with('ruangan', 'reference')->orderBy('created_at', 'desc')->get();
            return ResponseFormatter::success(new RequestCollection($requests), 'Data berhasil diambil');
        } else if (auth()->user()->hasRole('dosen')) {
            $krs_id = $request->krs_id;
            $dosen = User::find(auth()->user()->id)->dosen->nidn;
            // get request where pembimbing 1 or pembimbing 2 is dosen and krs in kelompok is $krs_id
            $requests = Request::whereHas('kelompok', function ($query) use ($krs_id) {
                $query->where('krs_id', 'LIKE', '%' . $krs_id . '%');
            })->whereHas('kelompok', function ($query) use ($dosen) {
                $query->whereHas('pembimbings', function ($query) use ($dosen) {
                    $query->where('pembimbing_1', $dosen)->orWhere('pembimbing_2', $dosen);
                });
            })->with('ruangan', 'reference')->orderBy('created_at', 'desc')->get();
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
        $pembimbing1 = $kelompok->pembimbings->pembimbing_1_dosen;
        $pembimbing2 = $kelompok->pembimbings->pembimbing_2_dosen;

        if ($pembimbing1 == null && $pembimbing2 == null) {
            return ResponseFormatter::error(null, 'Pembimbing tidak ditemukan', 500);
        }

        // send email to pembimbing
        $pembimbing1->user->notify(new RequestNotification($request, $kelompok));

        if ($pembimbing2 != null) {
            $pembimbing2->user->notify(new RequestNotification($request, $kelompok));
        }

        return ResponseFormatter::success(new RequestResource($request), 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $request = Request::find($id);
        return ResponseFormatter::success(new RequestResource($request), 'Data berhasil diambil');
    }
}
