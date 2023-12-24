<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\LangMiddleware::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        'verify_family_member_relation' => \App\Http\Middleware\Patients\VerifyFamilyMemberRelation::class,
        'verify_security_code' => \App\Http\Middleware\Patients\VerifySecurityCode::class,
        'verify_protocol_access_relation' => \App\Http\Middleware\Patients\VerifyProtocolAccessRelation::class,
        'verify_practice_access_relation' => \App\Http\Middleware\Patients\VerifyPracticeAccessRelation::class,
        'verify_billing_period_dates' => \App\Http\Middleware\Administrators\BillingPeriods\VerifyBillingPeriodDates::class,
        'verify_payment_date_social_work' => \App\Http\Middleware\Administrators\SocialWorks\VerifyPaymentDateSocialWork::class,
        'verify_closed_protocol' => \App\Http\Middleware\Administrators\InternalProtocols\VerifyClosedProtocol::class,
        'verify_open_protocol' => \App\Http\Middleware\Administrators\InternalProtocols\VerifyOpenProtocol::class,
        'verify_all_practices_signed' => \App\Http\Middleware\Administrators\InternalProtocols\VerifyAllPracticesSigned::class,
        'check_if_exists_loaded_practices' => \App\Http\Middleware\Administrators\InternalProtocols\CheckIfExistsLoadedPractices::class,
        'check_filtered_practices_to_print' => \App\Http\Middleware\Administrators\InternalProtocols\CheckFilteredPracticesToPrint::class,
        'check_protocol_can_sent_by_email' => \App\Http\Middleware\Administrators\InternalProtocols\CheckProtocolCanSentByEmail::class,
        'check_if_loaded_patient_email' => \App\Http\Middleware\Administrators\InternalPatients\CheckIfLoadedPatientEmail::class,
        'redirect_if_practice_not_signed' => \App\Http\Middleware\Patients\RedirectIfPracticeNotSigned::class,
        'verify_open_practice' => \App\Http\Middleware\Administrators\InternalProtocols\VerifyOpenPractice::class,
        'verify_practice_has_result' => \App\Http\Middleware\Administrators\InternalProtocols\VerifyPracticeHasResult::class,
        'set_internal_practice_price' => \App\Http\Middleware\Administrators\InternalProtocols\SetInternalPracticePrice::class,
        'check_nomenclator_when_updating_internal_protocol' => \App\Http\Middleware\Administrators\InternalProtocols\CheckNomenclatorWhenUpdatingInternalProtocol::class,
        'check_overlap_dates' => \App\Http\Middleware\Administrators\BillingPeriods\CheckOverlapDates::class,
        'check_self_sabotage' => \App\Http\Middleware\Administrators\Settings\Roles\CheckSelfSabotage::class,
        'unique_environment' => \App\Http\Middleware\Administrators\Settings\Roles\UniqueEnvironment::class,
        'redirect_if_not_my_profile' => \App\Http\Middleware\Administrators\Profiles\RedirectIfNotMyProfile::class,
        'combine_template_variables' => \App\Http\Middleware\Administrators\Determinations\CombineTemplateVariables::class,
        'redirect_if_not_match_pattern' => \App\Http\Middleware\Administrators\Determinations\RedirectIfNotMatchPattern::class,
        'verify_if_practice_signed_by_another' => \App\Http\Middleware\Administrators\InternalProtocols\VerifyIfPracticeIsSignedByAnother::class,
        'check_if_not_me' => \App\Http\Middleware\Administrators\Settings\Users\CheckIfNotMe::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
