<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use App\Models\Prescriber;
use App\Observers\PrescriberObserver;

use App\Models\InternalPatient;
use App\Observers\InternalPatientObserver;

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
        
        Prescriber::observe(PrescriberObserver::class);
        InternalPatient::observe(InternalPatientObserver::class);
    }
}
