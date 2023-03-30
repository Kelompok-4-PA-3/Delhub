<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use App\Models\Fakultas;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

class ProdiController extends Controller
{
        /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get prodis
        $prodis = prodi::latest()->get();
        $fakultas = fakultas::all();

        //render view with prodis
        return view('Prodi.index', compact('prodis', 'fakultas'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create(): View
    {
        $prodis = prodi::all();
        $fakultas = fakultas::all();
        $statuses = status::all();
        return view('Prodi.create', compact('prodis', 'fakultas', 'statuses'));
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
            'fakultas_id' => 'required',
            'nama' => 'required'
        ];

        $validasi = $request->validate($data);
        Prodi::create($validasi);

            return redirect('/prodi')->with('sukses','Program Studi has been created successfully.');

    }

    public function update(Request $request, $id)
    // : RedirectResponse
    {
        $data = [
            'fakultas_id' => 'required',
            'nama' => 'required'
        ];

        $validasi = $request->validate($data);
        Prodi::find($id)->update($validasi);

            return redirect('/prodi')->with('sukses','Program Studi has been created successfully.');


    }

    public function destroy($id)
    {
        $prodis = Prodi::find($id);
        $prodis->delete();

        return back();
    }
}
