<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interests = Interest::all();
        return view('Jadwal.index', compact('interests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jadwal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'required',
        ]);

        Interest::create($request->all());

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal created successfully.');
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
    public function edit(Interest $interest)
    {
        return view('interest.edit', compact('interest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interest $interest)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'required',
        ]);

        $interest->update($request->all());

        return redirect()->route('jadwal.index')
            ->with('success', 'Interest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interest $interest)
    {
        $interest->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal deleted successfully',
        ]);
    }
}
