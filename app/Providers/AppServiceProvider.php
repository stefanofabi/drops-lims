<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->bind(
            'App\Laboratory\Repositories\Patients\PatientRepositoryInterface',
            'App\Laboratory\Repositories\Patients\PatientRepository'
        );

        $this->app->bind(
            'App\Laboratory\Repositories\SocialWorks\SocialWorkRepositoryInterface',
            'App\Laboratory\Repositories\SocialWorks\SocialWorkRepository'
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }
}
