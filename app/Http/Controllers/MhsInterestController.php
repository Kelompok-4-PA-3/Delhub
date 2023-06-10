<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Models\Mahasiswa;
use App\Models\MhsInterest;
use Illuminate\Http\Request;

class MhsInterestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all mhsInterests with interest and mahasiswa, user, prodi where mahasiswa have relation with user and prodi
        $mhsinterests = MhsInterest::with('interest', 'mahasiswa.user', 'mahasiswa.prodi')->get();
        return view('mhsInterest.index', compact('mhsinterests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $interests = Interest::all();
        $mahasiswas = Mahasiswa::with('user')->get();
        return view('mhsInterest.create', compact('interests', 'mahasiswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'nim' => 'required',
            'interest_id' => 'required',
        ]);

        MhsInterest::create($request->all());

        return back()
            ->with('success', 'Antusias mahasiswa telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(MhsInterest $mhsInterest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MhsInterest $mhsInterest)
    {
        $interests = Interest::all();
        $mahasiswas = Mahasiswa::all();
        return view('mhsInterest.edit', compact('mhsInterest', 'interests', 'mahasiswas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MhsInterest $mhsInterest)
    {
        
        $request->validate([
            'nim' => 'required',
            'interest' => 'required',
        ]);

        $mhsInterest->update($request->all());

        return redirect()->route('mhsInterest.index')
            ->with('success', 'MhsInterest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MhsInterest $mhsInterest)
    {
        $mhsInterest->delete();

        return back()
        ->with('success', 'Antusias mahasiswa telah berhasil dihapus');
    }
}
