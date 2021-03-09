<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Repositories\Eloquent\PatientRepository;

use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Repositories\Eloquent\SocialWorkRepository;

use App\Contracts\Repository\PrescriberRepositoryInterface;
use App\Repositories\Eloquent\PrescriberRepository;

use App\Contracts\Repository\DeterminationRepositoryInterface;
use App\Repositories\Eloquent\DeterminationRepository;

use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Repositories\Eloquent\ProtocolRepository;

use App\Contracts\Repository\BillingPeriodRepositoryInterface;
use App\Repositories\Eloquent\BillingPeriodRepository;

use App\Contracts\Repository\NomenclatorRepositoryInterface;
use App\Repositories\Eloquent\NomenclatorRepository;

use App\Contracts\Repository\ReportRepositoryInterface;
use App\Repositories\Eloquent\ReportRepository;

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
        $this->app->bind(ProtocolRepositoryInterface::class, ProtocolRepository::class);
        $this->app->bind(BillingPeriodRepositoryInterface::class, BillingPeriodRepository::class);
        $this->app->bind(NomenclatorRepositoryInterface::class, NomenclatorRepository::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        
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
