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

use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;
use App\Repositories\Eloquent\PaymentSocialWorkRepository;

use App\Contracts\Repository\PlanRepositoryInterface;
use App\Repositories\Eloquent\PlanRepository;

use App\Contracts\Repository\AffiliateRepositoryInterface;
use App\Repositories\Eloquent\AffiliateRepository;

use App\Contracts\Repository\EmailRepositoryInterface;
use App\Repositories\Eloquent\EmailRepository;

use App\Contracts\Repository\PhoneRepositoryInterface;
use App\Repositories\Eloquent\PhoneRepository;

use App\Contracts\Repository\SecurityCodeRepositoryInterface;
use App\Repositories\Eloquent\SecurityCodeRepository;

use App\Contracts\Repository\PracticeRepositoryInterface;
use App\Repositories\Eloquent\PracticeRepository;

use App\Contracts\Repository\ResultRepositoryInterface;
use App\Repositories\Eloquent\ResultRepository;

use App\Contracts\Repository\SignPracticeRepositoryInterface;
use App\Repositories\Eloquent\SignPracticeRepository;

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
        $this->app->bind(PaymentSocialWorkRepositoryInterface::class, PaymentSocialWorkRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(AffiliateRepositoryInterface::class, AffiliateRepository::class);
        $this->app->bind(EmailRepositoryInterface::class, EmailRepository::class);
        $this->app->bind(PhoneRepositoryInterface::class, PhoneRepository::class);
        $this->app->bind(SecurityCodeRepositoryInterface::class, SecurityCodeRepository::class);
        $this->app->bind(PracticeRepositoryInterface::class, PracticeRepository::class);
        $this->app->bind(ResultRepositoryInterface::class, ResultRepository::class);
        $this->app->bind(SignPracticeRepositoryInterface::class, SignPracticeRepository::class);

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
