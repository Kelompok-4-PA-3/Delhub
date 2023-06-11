<?php

namespace App\Providers;

use App\Models\Krs;
use App\Models\Kelompok;
use App\Models\RoleKelompok;
use App\Models\PoinPenilaian;
use App\Policies\KelompokPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Kelompok::class => KelompokPolicy::class,
        // Krs::class => KrsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('pembimbing-kelompok', function ($user, $kelompok) {
            $kelompok = Kelompok::find($kelompok);
            if ($kelompok->pembimbings != NULL) {
                return $user->dosen->nidn == $kelompok->pembimbings->pembimbing_1 || $user->dosen->nidn == $kelompok->pembimbings->pembimbing_2;
            }
        });

        Gate::define('krs_owner', function ($user, Krs $krs) {
            // return $krs_id;
            // $krs = Krs::where('id', $krs_id)->first();
            if ($krs && ($user->dosen->nidn === $krs->dosen_mk || $user->dosen->nidn === $krs->dosen_mk_2)) {
                return true;
            }

            return false;
        });

        Gate::define('is_koordinator', function ($user, Kelompok $kelompok) {
            // return $krs_id;
            // $krs = Krs::where('id', $krs_id)->first();
            if ($kelompok->krs && ($user->dosen->nidn === $kelompok->krs->dosen_mk || $user->dosen->nidn === $kelompok->krs->dosen_mk_2)) {
                return true;
            }

            return false;
        });

        Gate::define('is_pembimbing', function ($user, Kelompok $kelompok) {
            $role = RoleKelompok::where('kelompok_id', $kelompok->id)->where('nidn', Auth::user()->dosen->nidn)
                ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', 'role_group_kelompoks.id')
                ->join('kategori_roles', 'role_group_kelompoks.kategori_id', 'kategori_roles.id')
                ->pluck('kategori_roles.nama');

            if (in_array('pembimbing', array_map('strtolower', $role->toArray()))) {
                return true;
            }
            return false;
        });

        Gate::define('dosen_role_allowed', function ($user, Kelompok $kelompok) {
            if (in_array($user->dosen->nidn, $kelompok->role_kelompok->pluck('nidn')->toArray())) {
                return true;
            }
            return false;
        });

        Gate::define('mahasiswa_allowed', function ($user, Kelompok $kelompok) {
            if (in_array($user->mahasiswa->nim, $kelompok->kelompok_mahasiswas->pluck('nim')->toArray())) {
                return true;
            }
            return false;
        });

        // Gate::define('role_penilaian_allowed', function ($user, Kelompok $kelompok){
        //     if (in_array($user->mahasiswa->nim, $kelompok->kelompok_mahasiswas->pluck('nim')->toArray())) {
        //         return true;
        //     }
        //     return false;
        // });

        Gate::define('role_penilaian_allowed', function ($user, RoleKelompok $role) {
            if ($user->dosen->nidn === $role->nidn) {
                return true;
            }
            return false;
        });

        Gate::define('role_penilaian_detail_allowed', function ($user, Kelompok $kelompok, PoinPenilaian $penilaian) {
            $check = array_intersect($user->dosen->role_kelompok->where('kelompok_id', $kelompok->id)->pluck('role_group_id')->toArray(), $penilaian->role_group_penilaian->pluck('role_group_id')->toArray());
            if (!empty($check)) {
                return true;
            }
            return false;
        });

        // Gate::define('permission-kelompok', function ($user, $kelompok) {
        //     $kelompok = Kelompok::find($kelompok);
        //     if ($kelompok->pembimbings != NULL) {
        //         return $user->dosen->nidn == $kelompok->pembimbings->pembimbing_1 || $user->dosen->nidn == $kelompok->pembimbings->pembimbing_2;
        //     }elseif
        // });

    }
}
