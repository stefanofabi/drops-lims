<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\Repository\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;

use App\Contracts\Repository\RoleRepositoryInterface;
use App\Repositories\Eloquent\RoleRepository;

use App\Contracts\Repository\PermissionRepositoryInterface;
use App\Repositories\Eloquent\PermissionRepository;

use App\Contracts\Repository\InternalPatientRepositoryInterface;
use App\Repositories\Eloquent\InternalPatientRepository;

use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Repositories\Eloquent\SocialWorkRepository;

use App\Contracts\Repository\PrescriberRepositoryInterface;
use App\Repositories\Eloquent\PrescriberRepository;

use App\Contracts\Repository\DeterminationRepositoryInterface;
use App\Repositories\Eloquent\DeterminationRepository;

use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Repositories\Eloquent\ProtocolRepository;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Repositories\Eloquent\InternalProtocolRepository;

use App\Contracts\Repository\BillingPeriodRepositoryInterface;
use App\Repositories\Eloquent\BillingPeriodRepository;

use App\Contracts\Repository\NomenclatorRepositoryInterface;
use App\Repositories\Eloquent\NomenclatorRepository;

use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;
use App\Repositories\Eloquent\PaymentSocialWorkRepository;

use App\Contracts\Repository\PlanRepositoryInterface;
use App\Repositories\Eloquent\PlanRepository;

use App\Contracts\Repository\SecurityCodeRepositoryInterface;
use App\Repositories\Eloquent\SecurityCodeRepository;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;
use App\Repositories\Eloquent\InternalPracticeRepository;

use App\Contracts\Repository\SignInternalPracticeRepositoryInterface;
use App\Repositories\Eloquent\SignInternalPracticeRepository;

use App\Contracts\Repository\FamilyMemberRepositoryInterface;
use App\Repositories\Eloquent\FamilyMemberRepository;

use App\Contracts\Repository\SystemParameterRepositoryInterface;
use App\Repositories\Eloquent\SystemParameterRepository;

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

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(InternalPatientRepositoryInterface::class, InternalPatientRepository::class);
        $this->app->bind(SocialWorkRepositoryInterface::class, SocialWorkRepository::class);
        $this->app->bind(PrescriberRepositoryInterface::class, PrescriberRepository::class);
        $this->app->bind(DeterminationRepositoryInterface::class, DeterminationRepository::class);
        $this->app->bind(ProtocolRepositoryInterface::class, ProtocolRepository::class);
        $this->app->bind(InternalProtocolRepositoryInterface::class, InternalProtocolRepository::class);
        $this->app->bind(BillingPeriodRepositoryInterface::class, BillingPeriodRepository::class);
        $this->app->bind(NomenclatorRepositoryInterface::class, NomenclatorRepository::class);
        $this->app->bind(PaymentSocialWorkRepositoryInterface::class, PaymentSocialWorkRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(SecurityCodeRepositoryInterface::class, SecurityCodeRepository::class);
        $this->app->bind(InternalPracticeRepositoryInterface::class, InternalPracticeRepository::class);
        $this->app->bind(SignInternalPracticeRepositoryInterface::class, SignInternalPracticeRepository::class);
        $this->app->bind(FamilyMemberRepositoryInterface::class, FamilyMemberRepository::class);
        $this->app->bind(SystemParameterRepositoryInterface::class, SystemParameterRepository::class);
        
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
