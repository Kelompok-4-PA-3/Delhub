<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Permission as PermissionModel;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission = PermissionModel::latest()->get();
        return view('permission.index',[
            'title' => 'Manajemen Permission',
            'permission' => $permission
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => 'required',
            'guard_name' => 'required',
        ];
        $validasi = $request->validate($data);
        $permission = new PermissionModel();
        $permission->name = $validasi['name'];
        $permission->guard_name = $validasi['guard_name'];
        $permission->save();
        // Permission::create([
        //     'name' =>$validasi['name'],
        //     'guard_name' =>$validasi['guard_name']
        // ]);

        return redirect()->back()->with('success', 'Permission baru telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'name' => 'required',
        ];
        $validasi = $request->validate($data);
        $permission = PermissionModel::find($id);
        $permission->name = $validasi['name'];
        $permission->save();

        return redirect()->back()->with('success', 'Permission baru telah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = PermissionModel::where('id',$id);
        $permission->delete();
        return redirect()->back()->with('success', 'Data permission telah berhasil dihapus');
    }
}
