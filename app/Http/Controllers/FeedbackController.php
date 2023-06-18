<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class FeedbackController extends Controller
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
    public function store(Request $request, Kelompok $kelompok)
    {
        $data = [
            'feedback' => 'required'
        ];

        $validasi = $request->validate($data);
    
        Feedback::create([
            'feedback' => $validasi['feedback'],
            'kelompok_id' => $kelompok->id,
            'poin_regulasi_id' => $request->poin_regulasi_id,
            'status' => 0,
        ]);

        return back()->with('success', 'Feedback telah berhasil dibuat')->with('feedback_session', $request->poin_regulasi_id);
    }

    public function update_status(Request $request, Kelompok $kelompok, Feedback $feedback)
    {
        $data_feedback = Feedback::find($feedback->id);
        $data_feedback->status = $request->status;
        $data_feedback->save();

        return back()->with('success', 'status feedback telah berhasil diupdate')->with('feedback_session', $request->poin_regulasi_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Kelompok $kelompok, Feedback $feedback)
    {
        $data_feedback = Feedback::find($feedback->id);
        $data_feedback->delete();

        return back()->with('success', 'status feedback telah berhasil dihapus')->with('feedback_session', true);
    }
}
