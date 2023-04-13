<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PembimbingPenguji;
use App\Services\CheckRole;
use Auth;

class CheckRoleProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CheckRole::class, function () {
            return new CheckRole();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
