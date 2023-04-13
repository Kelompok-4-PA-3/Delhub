<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\KrsUsers;

class AppServiceProvider extends ServiceProvider
{
/**
 * Register any application services.
 */
public function register(): void
{
    $this->app->singleton('request_bimbingan', function ($app) {
        return new \App\Services\RequestBimbingan;
    });

    $this->app->singleton('is_pembimbing', function ($app) {
        return new \App\Services\CheckRole;
    });
}

/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    view()->share('is_mahasiswa', function(){
        $user = Auth::user();
        if ($user->mahasiswa != NULL) {
                return true;
        }
        return false;
    });
}
}
