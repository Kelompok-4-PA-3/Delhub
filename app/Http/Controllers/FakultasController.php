<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use App\Models\Fakultas;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

class FakultasController extends Controller
{
        /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get prodis
        $prodis = prodi::latest()->paginate(5);
        $fakultas = fakultas::all();

        //render view with prodis
        return view('fakultas.index', compact('fakultas'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create(): View
    {
        // $statuses = status::all();
        return view('fakultas.create');
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
            'nama' => 'required|unique:fakultas|deleted_at,NULL'
        ];

        $validasi = $request->validate($data);
        Fakultas::create($validasi);

            return redirect('/fakultas')->with('sukses','fakultas has been created successfully.');

    }

    public function update(Request $request, $id)
    // : RedirectResponse
    {
        $data = [
            'nama' => 'required'
        ];
        $fakultas = Fakultas::find($id);
        if ($request->nama != $fakultas->nama) {
            $data['nama'] = 'unique:fakultas';
        }

        $validasi = $request->validate($data);
       $fakultas->update($validasi);

            return redirect('/fakultas')->with('sukses','Fakultas has been created successfully.');


    }

    public function destroy($id)
    {
        $prodis = Fakultas::find($id);
        $prodis->delete();

        return back();
    }
}
