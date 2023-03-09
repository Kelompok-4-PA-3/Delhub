<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interests = Interest::all();
        return view('interest.index', compact('interests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('interest.create');
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

        return redirect()->route('interest.index')
            ->with('success', 'Interest created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Interest $interest)
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

        return redirect()->route('interest.index')
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
            'message' => 'Interest deleted successfully',
        ]);
    }
}
