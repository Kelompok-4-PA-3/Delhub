<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Fakultas;
use App\Models\Status;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
        /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get prodis
        $prodis = prodi::latest()->paginate(5);

        //render view with prodis
        return view('Prodi.index', compact('prodis'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $prodis = prodi::all();
        $fakultas = fakultas::all();
        return view('Prodi.create', compact('prodis', 'fakultas'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required',
            'nama' => 'required',
            'status' => 'required'
            ]);
            $prodis = new Prodi;
            $prodis->fakultas_id = $request->fakultas_id;
            $prodis->nama = $request->nama;
            $prodis->status = $request->status;
            $prodis->save();
            return redirect()->route('Prodi.index')
            ->with('sukses','Company has been created successfully.');

    }
}
