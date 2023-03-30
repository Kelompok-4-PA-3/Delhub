<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

class RuanganController extends Controller
{
        /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get prodis
        $ruangans = ruangan::latest()->get();

        //render view with prodis
        return view('ruangan.index', compact('ruangans'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create(): View
    {
        $ruangans = ruangan::all();
        return view('ruangan.create', compact('ruangans'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        // return $request;
        // $validasi = $request->validate([
        //     'fakultas_id' => 'required',
        //     'nama' => 'required',
        // ]);

        $data = [
            'nama' => 'required'
        ];

        $validasi = $request->validate($data);
        Ruangan::create($validasi);

            return redirect('/ruangan')->with('sukses','Program Studi has been created successfully.');

    }

    public function update(Request $request, string $id)
    // : RedirectResponse
    {
        $data = [
            'nama' => 'required'
        ];
        $ruangans = Ruangan::find($id);

        $validasi = $request->validate($data);

        $ruangans->nama = $validasi['nama'];
        $ruangans->save();

        return redirect('/ruangan')->with('sukses','Program Studi has been created successfully.');


    }

    public function destroy($id)
    {
        $ruangans = Ruangan::find($id);
        $ruangans->delete();

        return back();
    }
}
