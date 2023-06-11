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
use App\Http\Controllers\KonfigurasiPenilaianController;
use App\Http\Controllers\PoinPenilaianController;
use App\Http\Controllers\RoleGroupKelompokController;
use App\Http\Controllers\NilaiMahasiswaController;
use App\Http\Controllers\NilaiMahasiswaRoleController;
use App\Http\Controllers\KategoriRoleController;
use App\Http\Controllers\RoleKelompokController;
use App\Http\Controllers\RoleKelompokPenilaianController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\TemplateDocumentController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\ImageProfileTemporariesController;
use App\Http\Controllers\SubmissionArtefakController;
use App\Http\Controllers\ArtefakKelompokController;
use App\Http\Controllers\ArtefakTemporaryController;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\KomponenPenilaianController;
use \App\Http\Controllers\RequestController;



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
})->middleware('auth');


// Route::resource('/prodi', \App\Http\Controllers\ProdiController::class);
// Route::get('/users/all', [UsersController::class,'getUsers']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/koordinator/proyeksaya/{id}', [MyProjectController::class, 'koordinator'])->name('koordinator_myproject_detail');
    Route::get('/koordinator/myproject', [MyProjectController::class, 'koordintor_job_list'])->name('koordinator_myproject');

    Route::get('/users/{user}/profile', [UsersController::class, 'profile'])->name('user_profile');
    Route::post('/users/{user}/profile/image', [UsersController::class, 'update'])->name('user_profile-image.store');
    // Route::post('/users/{user}/profile/image/edit', [UsersController::class, 'image_edit'])->name('user_profile-image.edit');
    // Route::post('/users/{user}/profile/image/delete', [UsersController::class, 'image_delete'])->name('user_profile-image.delete');

    //temporary image profile
    Route::post('/users/{user}/profile/image/temporary/store', [ImageProfileTemporariesController::class, 'store'])->name('user_profile-image-temporary.store');
    Route::post('/users/{user}/profile/image/temporary/edit', [ImageProfileTemporariesController::class, 'update'])->name('user_profile-image-temporary.edit');
    Route::post('/users/{user}/profile/image/temporary/delete', [ImageProfileTemporariesController::class, 'delete'])->name('user_profile-image-temporary.delete');

    Route::group(['middleware' => 'role:admin'], function () {
         // admin 
         // prodi
         Route::resource('/prodi', \App\Http\Controllers\ProdiController::class)->name('prodis', 'Prodi.index');
         // ruangan
         Route::resource('/ruangan', \App\Http\Controllers\RuanganController::class)->name('ruangans', 'ruangan.index');
         // fakultas
         Route::resource('/fakultas', \App\Http\Controllers\FakultasController::class)->name('fakultas', 'fakultas.index');
         // roles
         Route::resource('/roles', RolesController::class)->name('roles', 'roles.index');
         // permission
         Route::resource('/permission', PermissionController::class)->name('permission', 'permission.index');
         // kategori
         Route::resource('/kategori', KategoriController::class)->name('kategori', 'kategori.index');
         // krs
         Route::resource('/krs', KrsController::class)->name('krs', 'krs.index');
         // dosen
         Route::resource('/dosen', DosenController::class)->name('dosen', 'dosen.index');
         // mahasiswa
         Route::resource('/mahasiswa', MahasiswaController::class)->name('mahasiswa', 'mahasiswa.index');
         // users
         Route::resource('/users', UsersController::class)->name('users', 'users.index');
         // config
         Route::resource('/config', \App\Http\Controllers\ConfigController::class)->name('configs', 'config.index');
         Route::post('/config/update/status/{id}', [\App\Http\Controllers\ConfigController::class, 'update_status'])->name('configs', 'config.update_status');
         // interst
         Route::resource('/interest', InterestController::class)->name('interest', 'interest.index');
         // kategori proyek 
         Route::resource('/kategori_proyek', KategoriProyekController::class)->name('kategori_proyek', 'kategori_proyek.index');

        // Route::resource('/prodi', \App\Http\Controllers\ProdiController::class)->name('prodis', 'Prodi.index');
        Route::post('/users/upload', [UsersController::class, 'user_upload']);
        Route::get('/data/user', [UsersController::class, 'getUser']);
        Route::post('/users/krs/add', [DashboardController::class, 'add_user']);
        // endadmin 
    });
       
        
    // admin dan koordinator
    Route::group(['middleware' => 'role:admin,dosen'], function () {

         // poin regulasi
         Route::resource('/poin_regulasi', PoinRegulasiController::class)->name('poin_regulasi', 'poin_regulasi.index');
         Route::get('/pembimbing/{nidn}/', [MyProjectController::class, 'pembimbing']);
         Route::get('/dashboard/{id}', [DashboardController::class, 'show']);
         Route::get('/poin_regulasi/{poinRegulasi}/komponen_penilaian',[KomponenPenilaianController::class, 'index']);
         Route::post('/poin_regulasi/{poinRegulasi}/komponen_penilaian',[KomponenPenilaianController::class, 'store']);
         Route::post('/poin_regulasi/{poinRegulasi}/{komponenPenilaian}',[KomponenPenilaianController::class, 'update']);
         Route::post('/poin_regulasi/{poinRegulasi}/{komponenPenilaian}/delete',[KomponenPenilaianController::class, 'delete']);
         Route::post('/poin_regulasi/{poinRegulasi}/komponen_penilaian/verifikasi',[KomponenPenilaianController::class, 'verifikasi_komponen_penilaian']);

        // Kelompok
        // Route::post('/kelompok/dosen/pembimbing', [KelompokController::class, 'add_pembimbing']);
        // Route::post('/kelompok/dosen/penguji', [KelompokController::class, 'add_penguji']);
        // Route::post('/kelompok/dosen/pembimbing/{id}/delete', [KelompokController::class, 'delete_pembimbing']);
        // Route::post('/kelompok/dosen/penguji/{id}/delete', [KelompokController::class, 'delete_penguji']);
        Route::post('/kelompok/{kelompok}/people/add', [KelompokController::class, 'add_mahasiswa']);
        Route::post('/kelompok/{kelompok}/people/delete', [KelompokController::class, 'delete_mahasiswa']);

        Route::get('/kelompok/{kelompok}/artefak', [KelompokController::class, 'artefak']);
        Route::post('/kelompok/{kelompok}/artefak/{submission}', [ArtefakKelompokController::class, 'store']);
        Route::post('/kelompok/{kelompok}/artefak/{submission}/{artefak}/delete', [ArtefakKelompokController::class, 'delete']);
        Route::post('/artefak/file/temporary/store', [ArtefakTemporaryController::class, 'store'])->name('artefake-temporary.store');
        Route::post('/artefak/file/temporary/delete', [ArtefakTemporaryController::class, 'delete'])->name('artefake-temporary.delete');


        // Hasil penilaian
        Route::get('/krs/{kr}/hasil_penilaian', [PenilaianController::class, 'index'])->name('penilaian', 'penilaian.index');
        // Route::post('/krs/{kr}/hasil_penilaian', [PenilaianController::class, 'index'])->name('penilaian', 'penilaian.index');
        Route::get('/krs/{kr}/hasil_penilaian/penilaian/{penilaian}', [PenilaianController::class, 'detail_hasil_nilai'])->name('penilaian.detail', 'penilaian.detail');
        Route::get('/krs/{kr}/hasil_penilaian/penilaian/{penilaian}/export', [PenilaianController::class, 'export_excel_nilai'])->name('penilaian.export_nilai', 'penilaian.export_nilai');
            
        // Reguasi
        Route::get('/krs/{id}/regulasi', [RegulasiController::class, 'index'])->name('regulasi', 'regulasi.index');
        Route::get('/krs/{id}/regulasi/add', [RegulasiController::class, 'create'])->name('regulasi-add', 'regulasi.add');
        Route::post('/krs/{id}/regulasi/add', [RegulasiController::class, 'store'])->name('regulasi-store', 'regulasi.store');
        Route::post('/krs/{id}/regulasi/edit', [RegulasiController::class, 'update'])->name('regulasi-update', 'regulasi.update');
        Route::get('/krs/{id}/regulasi/show', [RegulasiController::class, 'show'])->name('regulasi-show', 'regulasi.show');
        Route::post('/krs/{id}/config-penilaian', [KonfigurasiPenilaianController::class, 'store'])->name('config-penilaian', 'config-penilaian.show');
            
        // Poin Penilaian
        Route::get('/krs/{kr}/poin_penilaian', [PoinPenilaianController::class, 'index'])->name('poin-penilaian', 'poin-penilaian.index');
        Route::post('/krs/{kr}/poin_penilaian/store', [PoinPenilaianController::class, 'store'])->name('poin-penilaian-store', 'poin-penilaian.store');
        Route::post('/krs/{kr}/poin_penilaian/store/{penilaian}/role', [PoinPenilaianController::class, 'store_role'])->name('poin-penilaian-role', 'poin-penilaian.role');
        Route::post('/krs/{kr}/poin_penilaian/store/{penilaian}/role/verifikasi', [PoinPenilaianController::class, 'role_verifikasi'])->name('poin-penilaian-role.verifikasi', 'poin-penilaian.role-verifikasi');
        Route::post('/krs/{kr}/poin_penilaian/delete/{penilaian}/role/{role_penilaian}', [PoinPenilaianController::class, 'delete_role'])->name('poin-penilaian-role.delete', 'poin-penilaian.role-delete');
        Route::post('/krs/{kr}/poin_penilaian/{poinPenilaian}/edit', [PoinPenilaianController::class, 'update'])->name('poin-penilaian.edit');
        Route::post('/krs/{kr}/poin_penilaian/{poinPenilaian}/delete', [PoinPenilaianController::class, 'delete'])->name('poin-penilaian.delete');
        Route::post('/krs/{kr}/poin_penilaian/verifikasi',[PoinPenilaianController::class, 'verifikasi_poin_penilaian']);
            
        // Komponen Penilaian
        Route::get('/krs/{kr}/poin_penilaian/{poinPenilaian}/komponen', [KomponenPenilaianController::class, 'index'])->name('komponen_penilaian.index');
        Route::post('/krs/{kr}/poin_penilaian/{poinPenilaian}/komponen/store', [KomponenPenilaianController::class, 'store'])->name('komponen_penilaian.store');
        Route::post('/krs/{kr}/poin_penilaian/{poinPenilaian}/komponen/{komponenPenilaian}/edit', [KomponenPenilaianController::class, 'update'])->name('komponen_penilaian.edit');
        Route::post('/krs/{kr}/poin_penilaian/{poinPenilaian}/komponen/{komponenPenilaian}/delete', [KomponenPenilaianController::class, 'delete'])->name('komponen_penilaian.delete');
        Route::post('/krs/{kr}/poin_penilaian/{poinPenilaian}/komponen/verifikasi', [KomponenPenilaianController::class, 'verifikasi_komponen_penilaian'])->name('komponen_penilaian.verifikasi');
            
        // Role Group Kelompok
        Route::get('/krs/{kr}/role_group/{kategori}', [RoleGroupKelompokController::class, 'index'])->name('role_group.index');
        Route::post('/krs/{kr}/role_group/{kategori}/store/', [RoleGroupKelompokController::class, 'store'])->name('role_group.store');
        Route::post('/krs/{kr}/role_group/{kategori}/{roleGroupKelompok}/edit', [RoleGroupKelompokController::class, 'edit'])->name('role_group.edit');
        Route::post('/krs/{kr}/role_group/{kategori}/{roleGroupKelompok}/delete', [RoleGroupKelompokController::class, 'delete'])->name('role_group.delete');
        Route::post('/krs/{kr}/role_group/{kategori}/verifikasi/{role}',[RoleGroupKelompokController::class, 'verifikasi_role_group'])->name('role_group.verification');
        Route::get('/krs/{kr}/role_group/role/{role}/komponen/',[RoleKelompokPenilaianController::class, 'index'])->name('role_kelompok_penilaian.index');
        Route::post('/krs/{kr}/role_group/role/{role}/komponen/store',[RoleKelompokPenilaianController::class, 'store'])->name('role_kelompok_penilaian.store');
        Route::post('/krs/{kr}/role_group/role/{role}/komponen/{rolePenilaian}/edit',[RoleKelompokPenilaianController::class, 'update'])->name('role_kelompok_penilaian.update');
        Route::post('/krs/{kr}/role_group/role/{role}/komponen/{rolePenilaian}/delete',[RoleKelompokPenilaianController::class, 'delete'])->name('role_kelompok_penilaian.delete');
        Route::post('/krs/{kr}/role_group/role/{role}/komponen/verifikasi',[RoleKelompokPenilaianController::class, 'verifikasi_kompnen_penilaian'])->name('role_kelompok_penilaian.verification');
    
        // Kategori Role
        Route::get('/krs/{kr}/kategori_role', [KategoriRoleController::class, 'index'])->name('kategori_role.index');
        Route::post('/krs/{kr}/kategori_role/store', [KategoriRoleController::class, 'store'])->name('kategori_role.store');
        Route::post('/krs/{kr}/kategori_role/{kategori}/edit', [KategoriRoleController::class, 'update'])->name('kategori_role.edit');
        Route::post('/krs/{kr}/kategori_role/{kategori}/delete', [KategoriRoleController::class, 'delete'])->name('kategori_role.delete');

        //template document 
        Route::get('/krs/{kr}/document', [TemplateDocumentController::class, 'index'])->name('template_document.index');
        Route::post('/krs/{kr}/document', [TemplateDocumentController::class, 'store'])->name('template_document.add');
        Route::post('/krs/{kr}/document/{document}/edit', [TemplateDocumentController::class, 'update'])->name('template_document.edit');
        Route::post('/krs/{kr}/document/{document}/delete', [TemplateDocumentController::class, 'delete'])->name('template_document.delete');
        Route::post('/krs/{kr}/document/publish', [TemplateDocumentController::class, 'publish'])->name('template_document.publish');

        // submission proyek
        Route::get('/krs/{kr}/submission', [SubmissionArtefakController::class, 'index'])->name('template_submission.index');
        Route::post('/krs/{kr}/submission/store', [SubmissionArtefakController::class, 'store'])->name('template_submission.store');
        Route::post('/krs/{kr}/submission/{submission}/edit', [SubmissionArtefakController::class, 'update'])->name('template_submission.update');
        Route::post('/krs/{kr}/submission/{submission}/delete', [SubmissionArtefakController::class, 'delete'])->name('template_submission.delete');
        // Route::get('/krs/{kr}/submission', [SubmissionArtefakController::class, 'index'])->name('template_submission.index');
        
        
    });


    Route::group(['middleware' => 'role:mahasiswa'], function () {
        Route::post('/bimbingan/upload/{id}', [BimbinganController::class, 'upload_bukti'])->name('bimbingan_upload', 'bimbingan.upload_bukti');
        Route::resource('/mhsInterest', MhsInterestController::class)->name('mhsInterest', 'mhsInterest.index');
    });

    Route::group(['middleware' => 'role:admin,dosen,mahasiswa'], function () {
        Route::post('/bimbingan/upload/{id}', [BimbinganController::class, 'upload_bukti'])->name('bimbingan_upload', 'bimbingan.upload_bukti');
        Route::get('/kelompok/{id}/orang', [KelompokController::class, 'people']);
        Route::resource('/kelompok', KelompokController::class)->name('kelompok', 'kelompok.index');
        Route::resource('/home', DashboardController::class)->name('home', 'home.index');

    });

    Route::group(['middleware' => 'role:dosen,mahasiswa'], function () {
        // request
        Route::resource('/request', \App\Http\Controllers\RequestController::class)->name('requests', 'request.index');
        Route::resource('/bimbingan', BimbinganController::class)->name('bimbingan', 'bimbingan.index');
        Route::post('/kelompok/topik', [KelompokController::class, 'add_topik']);

    });


    Route::group(['middleware' => 'role:dosen'], function () {
        //Nilai Mahasiswa Role
        // Route::get('/kelompok/{kelompok}/penilaian/role_kelompok/{role}/{roleGroup}', [NilaiMahasiswaRoleController::class, 'index'])->name('nilai_mahasiswa_role');
        // Route::post('/kelompok/{kelompok}/penilaian/role_kelompok/{role}/{roleGroup}/komponen/store', [NilaiMahasiswaRoleController::class, 'store'])->name('nilai_mahasiswa_role.store');
        // Nilai Mahasiswa
        Route::get('/kelompok/{kelompok}/penilaian/role/{role}', [KelompokController::class, 'penilaian']);
        Route::get('/kelompok/{kelompok}/penilaian/role/{role}/{penilaian}', [NilaiMahasiswaController::class, 'index'])->name('nilai_mahasiswa');
        Route::post('/kelompok/{kelompok}/penilaian/role/{role}/{penilaian}/approved', [NilaiMahasiswaController::class, 'update_status'])->name('nilai_mahasiswa.update_status');
        Route::post('/kelompok/{kelompok}/penilaian/{penilaian}/approved', [NilaiMahasiswaController::class, 'update_status_koordinator'])->name('nilai_mahasiswa.update_status-koordinator');
        Route::post('/kelompok/{kelompok}/penilaian/role/{role}/{penilaian}/komponen/store', [NilaiMahasiswaController::class, 'store'])->name('nilai_mahasiswa.store');

        Route::post('/kelompok/{kelompok}/role/add', [RoleKelompokController::class, 'store'])->name('kelompok_role.add');
        Route::post('/kelompok/{kelompok}/role/{roleKelompok}/delete', [RoleKelompokController::class, 'delete'])->name('kelompok_role.delete');
        
        
        Route::post('/bimbingan/approve/{id}', [BimbinganController::class, 'approve_bukti'])->name('bimbingan_approve', 'bimbingan.approve_bukti');
        Route::get('/bimbingan/status/{status}/{id}', [BimbinganController::class, 'update_status'])->name('bimbingan_status', 'bimbingan.update_status');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    });
    
    // Route::group(['middleware' => 'role:koordinator'], function () {
        Route::post('/kelompok/{kelompok}/verfikasi/role', [RoleKelompokController::class, 'verification'])->name('kelompok_role.verfication');
    // });




    Route::post('/request/{bimbingan}/delete-file', [RequestController::class, 'update'])->name('requests.file-delete', 'request.index');
    // Route::post('/kelompok/{kelompok}/document/form-control', [WordController::class, 'form_control_bimbingan'])->name('word-export.form_control');

    // Route::resource('/prodi', \App\Http\Controllers\ProdiController::class)->name('prodis', 'Prodi.index');

    Route::resource('/jadwal', \App\Http\Controllers\JadwalController::class)->name('jadwals', 'jadwal.index');


    // Data Master
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
Route::get('/test', function() {
    Artisan::call('storage:link');
 });