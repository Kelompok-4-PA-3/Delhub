<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Models\Roles as RoleModel;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Hash;

class UsersController extends Controller
{
    public function getUser()
    {
        $user = User::latest()->get();
        return json_encode($user);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = User::latest()->get();
        $roles = RoleModel::latest()->get();
        return view('users.index', [
            'title' => 'Manajemen Pengguna',
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = RoleModel::latest()->get();
        return view('users.add', [
            'title' => ' <i class="ph-users"></i> Manajemen Pengguna',
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function user_upload(Request $request)
    {
        // return $request;
        // if($request->file('user-file')){
        //     return "iya";
        // }else{
        //     return " tidak";
        // }

        Excel::import(new UsersImport, request()->file('user-file'));
        return back()->with('success', 'Pengguna baru telah berhasil ditambahkan');
    }

    public function store(Request $request)
    // : RedirectResponse
    {
        return $request;
        // return $request;
        $data = [
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'roles' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ];

        $validasi = $request->validate($data);

        $password = Hash::make($request->password);

        $user = new User();
        $user->nama = $validasi['nama'];
        $user->username = $validasi['username'];
        $user->email = $validasi['email'];
        $user->password = $password;
        foreach ($request->roles as $r) {
            $user->assignRole($r);
            // return $r;
        }
        $user->destroyer;
        $user->save();

        return redirect('/users')->with('success', 'Pengguna baru telah behasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    // : RedirectResponse
    {
        // return $request;
        $data = [
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'roles' => 'required',
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable',
        ];

        $validasi = $request->validate($data);

        $user = User::where('id', $user->id)->first();
        $user->nama = $validasi['nama'];
        $user->username = $validasi['username'];
        $user->email = $validasi['email'];
        $user->syncRoles([]);
        foreach ($request->roles as $r) {
            $user->assignRole($r);
        }
        if ($request->password !== null) {
            $user->password = Hash::make($validasi['password']);
        }
        $user->save();

        return redirect('/users')->with('success', 'Data penguna telah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->back()->with('success', 'Data pengguna telah berhasil dihapus');
    }
}
