<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\Kelompok;
// use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

class RequestController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(): View
    {
        //get prodis
        $requests = request::latest()->get();
        $kelompoks = kelompok::all();

        //render view with prodis
        return view('request.index', compact('requests', 'kelompoks'));
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
