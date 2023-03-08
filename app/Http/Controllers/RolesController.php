<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Permission as PermissionModel;
use App\Models\RolePermission;
use App\Models\Roles as RoleModel;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = RoleModel::latest()->get();
        // $selected_permission =RoleModel::role_permission->toArray();
        // return $selected_permission;
        // Role::join('role_has_permissions', 'role_has_permissions.role_id', '=', 'roles.id')->get();
                        // ->select('roles.*', 'role_has_permissions.permission_id')

        $permission = PermissionModel::latest()->get();
        // return $role;
        return view('roles.index',[
            'title' => 'Manajemen Role',
            'roles' => $role,
            'permission' => $permission,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $role = Role::get();
        // return view('roles.create',[
        //     'roles' => $role
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => 'required|unique:roles',
            'guard_name' => 'required',
        ];
        $validasi = $request->validate($data);
        $role = new RoleModel();
        $role->name = $validasi['name'];
        $role->guard_name = $validasi['guard_name'];
        $role->save();
        // $role = Role::create([
        //     'name' => $validasi['name'],
        //     'guard_name' => $validasi['guard_name']
        // ]);

        // return $role->id;

        try {
            $role_permission = Role::find($role->id);
        } catch (Exception $e) {
            return redirect()->back()->with('failed', $e);
        }

        foreach ($request->permission as $p) {
            try{
                $role_permission->givePermissionTo($p);
            }catch(Exception $e){
                return redirect()->back()->with('failed', $e);
            }
        }

        return redirect()->back()->with('success', 'Role baru telah berhasil dibuat');

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
        // return $request;
        $data = [
            'name_edit' => 'required',
        ];

    //    return $id;
        $role = Role::find($id);
        $role->syncPermissions([]);

        if ($request->name_edit != $role->name) {
            $data['name_edit'] = 'required|unique:roles,name';
        }

        $validasi = $request->validate($data);

        $role->name = $validasi['name_edit'];
        $role->save();

        // if ($request->guard_name_edit != $role->guard_name) {
        //     return redirect()->back()->with('failed', 'Perubahan guard name berhasil diubah namun permission gagal diterapkan karena tidak berada pada guard name yang sama');
        // }

        foreach ($request->permission as $p) {
            try{
                $role->givePermissionTo($p);
            }catch(Exception $e){
                return redirect()->back()->with('failed', $e);
            }
        }

        return redirect()->back()->with('success', 'Role baru telah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roles = RoleModel::where('id',$id);
        $roles->delete();
        return redirect()->back()->with('success', 'Data role telah berhasil dihapus');
    }
}
