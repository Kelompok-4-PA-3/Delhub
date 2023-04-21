<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\MhsInterestController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RegulasiController;
use App\Http\Controllers\KategoriProyekController;
use App\Http\Controllers\PoinRegulasiController;
use App\Http\Controllers\MyProjectController;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Spatie\Permission\Models\Role;



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
        // return Auth::user()->dosen;

        return view('index');
    })->name('dashboard');

    Route::resource('/prodi', \App\Http\Controllers\ProdiController::class)->name('prodis', 'Prodi.index');
    Route::resource('/ruangan', \App\Http\Controllers\RuanganController::class)->name('ruangans', 'ruangan.index');
    Route::resource('/request', \App\Http\Controllers\RequestController::class)->name('requests', 'request.index');

    Route::resource('/prodi', \App\Http\Controllers\ProdiController::class)->name('prodis', 'Prodi.index');

    Route::resource('/jadwal', \App\Http\Controllers\JadwalController::class)->name('jadwals', 'jadwal.index');

    Route::resource('/config', \App\Http\Controllers\ConfigController::class)->name('configs', 'config.index');
    Route::post('/config/update/status/{id}', [\App\Http\Controllers\ConfigController::class, 'update_status'])->name('configs', 'config.update_status');

    


    Route::resource('/prodi', \App\Http\Controllers\ProdiController::class)->name('prodis', 'Prodi.index');
    Route::resource('/fakultas', \App\Http\Controllers\FakultasController::class)->name('fakultas', 'fakultas.index');
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
    Route::resource('/interest', InterestController::class)->name('interest', 'interest.index');
    Route::resource('/mhsInterest', MhsInterestController::class)->name('mhsInterest', 'mhsInterest.index');
    Route::resource('/kelompok', KelompokController::class)->name('kelompok', 'kelompok.index');
    Route::post('/kelompok/dosen/pembimbing', [KelompokController::class, 'add_pembimbing']);
    Route::post('/kelompok/dosen/penguji', [KelompokController::class, 'add_penguji']);
    Route::post('/kelompok/dosen/pembimbing/{id}/delete', [KelompokController::class, 'delete_pembimbing']);
    Route::post('/kelompok/dosen/penguji/{id}/delete', [KelompokController::class, 'delete_penguji']);
    Route::post('/kelompok/topik', [KelompokController::class, 'add_topik']);
    Route::post('/kelompok/people/add', [KelompokController::class, 'add_mahasiswa']);
    Route::post('/kelompok/people/delete', [KelompokController::class, 'delete_mahasiswa']);
    Route::get('/kelompok/{id}/orang', [KelompokController::class, 'people']);
    Route::resource('/bimbingan', BimbinganController::class)->name('bimbingan', 'bimbingan.index');
    Route::post('/bimbingan/upload/{id}', [BimbinganController::class, 'upload_bukti'])->name('bimbingan_upload', 'bimbingan.upload_bukti');
    Route::post('/bimbingan/approve/{id}', [BimbinganController::class, 'approve_bukti'])->name('bimbingan_approve', 'bimbingan.approve_bukti');
    Route::get('/bimbingan/status/{status}/{id}', [BimbinganController::class, 'update_status'])->name('bimbingan_status', 'bimbingan.update_status');

    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');

    Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.ubah');
    Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'delete'])->name('jadwal.delete');
    Route::get('/krs/{id}/regulasi', [RegulasiController::class, 'index'])->name('regulasi', 'regulasi.index');
    Route::get('/krs/{id}/regulasi/add', [RegulasiController::class, 'create'])->name('regulasi-add', 'regulasi.add');
    Route::post('/krs/{id}/regulasi/add', [RegulasiController::class, 'store'])->name('regulasi-store', 'regulasi.store');
    Route::post('/krs/{id}/regulasi/edit', [RegulasiController::class, 'update'])->name('regulasi-update', 'regulasi.update');
    Route::get('/krs/{id}/regulasi/show', [RegulasiController::class, 'show'])->name('regulasi-show', 'regulasi.show');
    Route::resource('/kategori_proyek', KategoriProyekController::class)->name('kategori_proyek', 'kategori_proyek.index');
    Route::resource('/poin_regulasi', PoinRegulasiController::class)->name('poin_regulasi', 'poin_regulasi.index');
    Route::get('/koordinator/proyeksaya/{id}', [MyProjectController::class, 'koordintor']);
    Route::get('/pembimbing/{nidn}/', [MyProjectController::class, 'pembimbing']);
    Route::get('/dashboard/{id}', [DashboardController::class, 'show']);


    // test
    Route::get('/mahasiswas/adds', function () {
        $mahasiswa = Mahasiswa::join('users', 'users.id', '=', 'mahasiswas.user_id')->get();
        foreach ($mahasiswa as $m) {
            $m->user->assignRole('mahasiswa');
        }
        return 'berhasil';
    });

    Route::get('/dosens/adds', function () {
        $dosen = Dosen::join('users', 'users.id', '=', 'dosens.user_id')->get();
        foreach ($dosen as $d) {
            $d->user->assignRole('dosen');
        }
        return 'berhasil';
    });
});
