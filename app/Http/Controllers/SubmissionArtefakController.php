<?php

namespace App\Http\Controllers;

use App\Models\SubmissionArtefak;
use App\Models\Krs;
use Illuminate\Http\Request;

class SubmissionArtefakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Krs $kr)
    {
        $submission = SubmissionArtefak::where('krs_id', $kr->id)->latest()->get();
        return view('dashboard.artefak_submission.index',[
            'submission' => $submission,
            'krs' => $kr
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
    public function store(Request $request, Krs $kr)
    {
        // return $request;
        $data = [
            'deskripsi' => 'required',
            'deadline' => 'required',
        ];

        $validasi = $request->validate($data);

        SubmissionArtefak::create([
            'krs_id' => $kr->id,
            'deskripsi' => $validasi['deskripsi'],
            'deadline' => $validasi['deadline'],
        ]);

        return back()->with('success', 'Submission artefak telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show( SubmissionArtefak $submissionArtefak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubmissionArtefak $submissionArtefak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $kr, SubmissionArtefak $submission)
    {
        $data = [
            'deskripsi' => 'required',
            'deadline' => 'required',
        ];

        $validasi = $request->validate($data);

        SubmissionArtefak::find($submission->id)->update([
            'deskripsi' => $validasi['deskripsi'],
            'deadline' => $validasi['deadline'],
        ]);

        return back()->with('success', 'Submission artefak telah berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubmissionArtefak $submissionArtefak)
    {
        //
    }
}
