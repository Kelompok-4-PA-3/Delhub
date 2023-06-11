<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use App\Models\Fakultas;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;

class FakultasController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(): View
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

        $data = $request->validate([
            'nama' => [
                'required',
                Rule::unique('fakultas', 'nama')->whereNull('deleted_at')
            ]
        ]);

        Fakultas::create($data);

        return redirect('/fakultas')->with('sukses', 'fakultas has been created successfully.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => [
                'required',
                Rule::unique('fakultas', 'nama')->whereNull('deleted_at')->ignore($id)
            ]
        ]);

        $fakultas = Fakultas::find($id);
        $fakultas->update($data);

        return redirect('/fakultas')->with('sukses', 'Fakultas has been created successfully.');
    }

    public function destroy($id)
    {
        $prodis = Fakultas::find($id);
        $prodis->delete();

        return back();
    }
}
