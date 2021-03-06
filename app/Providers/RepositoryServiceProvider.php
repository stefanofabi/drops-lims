<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Laboratory\Repositories\Patients\PatientRepositoryInterface;
use App\Laboratory\Repositories\Patients\PatientRepository;

use App\Laboratory\Repositories\SocialWorks\SocialWorkRepositoryInterface;
use App\Laboratory\Repositories\SocialWorks\SocialWorkRepository;

use App\Laboratory\Repositories\Prescribers\PrescriberRepositoryInterface;
use App\Laboratory\Repositories\Prescribers\PrescriberRepository;

use App\Laboratory\Repositories\Determinations\DeterminationRepositoryInterface;
use App\Laboratory\Repositories\Determinations\DeterminationRepository;

use App\Laboratory\Repositories\Protocols\Our\OurProtocolRepositoryInterface;
use App\Laboratory\Repositories\Protocols\Our\OurProtocolRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register all of the repository bindings.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
        $this->app->bind(SocialWorkRepositoryInterface::class, SocialWorkRepository::class);
        $this->app->bind(PrescriberRepositoryInterface::class, PrescriberRepository::class);
        $this->app->bind(DeterminationRepositoryInterface::class, DeterminationRepository::class);
        $this->app->bind(OurProtocolRepositoryInterface::class, OurProtocolRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
