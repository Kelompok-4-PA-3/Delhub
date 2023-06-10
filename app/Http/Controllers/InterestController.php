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
        $interests = Interest::latest()->get();
        return view('interest.index', compact('interests'));
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
            'nama' => 'required',
            'keterangan' => 'required',
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
        return view('interest.edit', ['interest' => $interest]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, interest $interest)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'required',
        ]);

        $interest->update($request->all());

        return redirect()->route('interest.index')
            ->with('success', 'interest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(interest $interest)
    {
        $interest->delete();

        return back()->with('success','Data antusias telah berhasil dihapus');
    }
}
