<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Models\Request as Bimbingan;
use App\Models\Kelompok;
use App\Models\Pembimbing;
use Auth;

class RequestController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    // : View
    {
        $requests = Pembimbing::where('pembimbing_1', Auth::user()->dosen->nidn)
            ->orWhere('pembimbing_2', Auth::user()->dosen->nidn)
            ->join('kelompoks', function ($kelompok) {
                $kelompok->on('pembimbings.kelompok_id', '=', 'kelompoks.id')
                    ->join('requests', 'requests.kelompok_id', '=', 'kelompoks.id');
            })
            ->select('kelompoks.nama_kelompok', 'requests.*')
            ->get();

        // return $requests;
        // $requests = Bimbingan::latest()->get();
        // $kelompoks = kelompok::all();

        //render view with prodis
        return view('request.index', compact('requests'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create(): View
    {
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
    }

    public function update(Request $request, $id)
    // : RedirectResponse
    {
    }

    public function destroy($id)
    {
        $requests = request::find($id);
        $requests->delete();

        return back();
    }
}
