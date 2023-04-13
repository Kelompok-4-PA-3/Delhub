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
        // get all mhsInterests with interest and mahasiswa, user, prodi where mahasiswa have relation with user and prodi
        $mhsinterests = Interest::with('interest', 'mahasiswa.user', 'mahasiswa.prodi')->get();
        return view('interest.index', compact('mhsinterests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $interests = Interest::all();
        return view('interest.create', compact('interests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'interest_id' => 'required',
        ]);

        interest::create($request->all());

        return redirect()->route('interest.index')
            ->with('success', 'interest created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(interest $interest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(interest $interest)
    {
        $interests = Interest::all();
        return view('interest.edit', compact('interests', 'mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, interest $interest)
    {
        $request->validate([
            'nim' => 'required',
            'interest' => 'required',
        ]);

        $mhsInterest->update($request->all());

        return redirect()->route('interest.index')
            ->with('success', 'interest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(interest $interest)
    {
        $mhsInterest->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'interest deleted successfully',
        ]);
    }
}
