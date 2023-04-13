<?php

namespace App\Http\Controllers\API\Student;

use App\Models\User;
use App\Models\Request;
use App\Models\Kelompok;
use App\Models\Reference;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequest;
use App\Http\Resources\RequestCollection;
use App\Notifications\RequestNotification;

class RequestController extends Controller
{
    public function index()
    {
        $kelompok_id = User::find(auth()->user()->id)->mahasiswa->kelompok_mahasiswa->where('status', '1')->first()->kelompok->id ?? null;
        $requests = Request::where('kelompok_id', $kelompok_id)->get();
        return ResponseFormatter::success(new RequestCollection($requests), 'Data berhasil diambil');
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();
        $ref = Reference::where('kategori', '=', 'status_bimbingan_default')->first();
        $data['status'] = $ref->id;
        Request::create($data);

        $kelompok = Kelompok::find($data['kelompok_id']);
        $dosen = $kelompok->dosen->user;

        // send email to dosen
        $dosen->notify(new RequestNotification($kelompok));

        return ResponseFormatter::success($request, 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $request = Request::find($id);
        return ResponseFormatter::success($request, 'Data berhasil diambil');
    }
}
