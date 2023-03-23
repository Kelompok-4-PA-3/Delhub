<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MhsInterestController;
use App\Http\Controllers\kelompokController;
use App\Http\Controllers\BimbinganController;

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


// Route::resource('/prodi', \App\Http\Controllers\ProdiController::class);
// Route::get('/users/all', [UsersController::class,'getUsers']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');

    Route::resource('/prodi', \App\Http\Controllers\ProdiController::class)->name('prodis', 'Prodi.index');
<<<<<<< HEAD
    Route::resource('/ruangan', \App\Http\Controllers\RuanganController::class)->name('ruangans', 'ruangan.index');

=======
    Route::resource('/fakultas', \App\Http\Controllers\FakultasController::class)->name('fakultas', 'fakultas.index');
>>>>>>> a0adde0 (Fakultas)
    Route::resource('/users', UsersController::class)->name('users', 'users.index');
    Route::post('/users/upload', [UsersController::class, 'user_upload']);
    Route::get('/data/user', [UsersController::class, 'getUser']);
    Route::resource('/roles', RolesController::class)->name('roles', 'roles.index');
    Route::resource('/permission', PermissionController::class)->name('permission', 'permission.index');
    Route::resource('/kategori', KategoriController::class)->name('kategori', 'kategori.index');
    Route::resource('/krs', KrsController::class)->name('krs', 'krs.index');
    Route::resource('/dosen', DosenController::class)->name('dosen', 'dosen.index');
    Route::resource('/mahasiswa', MahasiswaController::class)->name('mahasiswa', 'mahasiswa.index');
    Route::resource('/home', DashboardController::class)->name('home', 'home.index');
    Route::post('/users/krs/add', [DashboardController::class, 'add_user']);
    Route::resource('/mhsInterest', MhsInterestController::class)->name('mhsInterest', 'mhsInterest.index');
    Route::resource('/kelompok', KelompokController::class)->name('kelompok', 'kelompok.index');
    Route::post('/kelompok/dosen', [KelompokController::class, 'add_pembimbing']);
    Route::resource('/bimbingan', BimbinganController::class)->name('bimbingan', 'bimbingan.index');
    Route::get('/bimbingan/status/{status}/{id}', [BimbinganController::class, 'update_status'])->name('bimbingan', 'bimbingan.index');

    Route::get('/dashboard/{id}', [DashboardController::class, 'show']);
});
