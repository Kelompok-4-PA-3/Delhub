<?php

namespace App\Http\Controllers;

use App\Models\Configs;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $config = Configs::latest()->get();
        $years = range(2022, 2099);
        return view('config.index',[
            'config' => $config,
            'years' => $years
        ]);
    }

    public function update_status(Request $request, $id){
        // return $request;
        $config_active = Configs::where('active',true)->get();
        $config = Configs::where('id',$id)->first();
        if ($request->status == "active") {
            foreach($config_active as $c){
                $c->active = false;
                $c->save();
            }
            $config->active = true;
            $config->save();
            return back()->with('success','Konfigurasi berhasil diaktifkan');
        }else{
            $config->active = false;
            $config->save();
            return back()->with('success','Konfigurasi berhasil dinonaktifkan');
        }
       
        return back()->with('failed','Konfigurasi gagal diaktifkan');
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $data = [
            'tahun_aktif' => 'required',
            'semester' => 'required',
        ];

        $validasi = $request->validate($data);

        Configs::create([
            'tahun_aktif' => $validasi['tahun_aktif'],
            'semester' => $request['semester'],
        ]);

        return back()->with('success', 'Data konfigurasi telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Configs $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Configs $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configs $config)
    {
        $data = [
            'tahun_aktif' => 'required',
            'semester' => 'required',
        ];

        $validasi = $request->validate($data);

        Configs::find($config->id)->update($validasi);

        return back()->with('success', 'Data config berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Configs $config)
    {
        Configs::find($config->id)->delete();

        return back()->with('success', 'Data config berhasil dihapus');
    }
}
