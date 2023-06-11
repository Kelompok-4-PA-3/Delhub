<?php

namespace App\Providers;

// use App\Models\Kelompok;
// use App\Policies\KelompokPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class GateServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    // protected $policies = [
    //     Kelompok::class => KelompokPolicy::class,
    // ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        dd("this called");


        // Gate::define('kelola-bimbingan', function ($user, $kelompok) {
        //     Gate::define('kelola-bimbingan', [KelompokPolicy::class, 'kelolaBimbingan']);
        // });
    }
}
