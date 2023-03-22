<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Permission as PermissionModel;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;

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
        // $permission = new PermissionModel();
        // $permission->name = $validasi['name'];
        // $permission->guard_name = $validasi['guard_name'];
        // $permission->save();
        
        try {
            Permission::create($validasi);
        } catch (PermissionAlreadyExists $e) {
            // if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            //     throw new Exception('The permission name ' .$validasi['name']. ' already exists.');
            // } else {
            //     throw $e;
            // }
            return redirect()->back()->with('failed', "Permission telah terdaftar pada guard name yang sama");
            // if ($e->errorInfo[1] == 1062) {
            //     return back()->with('failed','Permission telah terdaftar pada guard name yang sama');
            // } else {
            //     // Other query exception
            //     throw $e;
            // }
        }

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
