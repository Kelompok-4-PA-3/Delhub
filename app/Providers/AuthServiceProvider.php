<?php

namespace App\Providers;

use App\Models\Kelompok;
use App\Policies\KelompokPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Kelompok::class => KelompokPolicy::class,
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

        // Gate::define('permission-kelompok', function ($user, $kelompok) {
        //     $kelompok = Kelompok::find($kelompok);
        //     if ($kelompok->pembimbings != NULL) {
        //         return $user->dosen->nidn == $kelompok->pembimbings->pembimbing_1 || $user->dosen->nidn == $kelompok->pembimbings->pembimbing_2;
        //     }elseif
        // });

    }
}
