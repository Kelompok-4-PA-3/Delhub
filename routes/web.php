<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


// Route::get('/users/all', [UsersController::class,'getUsers']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');

    Route::resource('/users', UsersController::class)->name('users','users.index');
    Route::get('/data/user', [UsersController::class, 'getUser']);
    Route::resource('/roles', RolesController::class)->name('roles','roles.index');
    Route::resource('/permission', PermissionController::class)->name('permission', 'permission.index');
});
