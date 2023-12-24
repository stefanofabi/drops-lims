<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Models\User;
use App\Observers\UserObserver;

use App\Models\InternalPatient;
use App\Observers\InternalPatientObserver;

use App\Models\Prescriber;
use App\Observers\PrescriberObserver;

use App\Listeners\UserLoginAt;
use Illuminate\Auth\Events\Login;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            UserLoginAt::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //

        User::observe(UserObserver::class);
        InternalPatient::observe(InternalPatientObserver::class);
        Prescriber::observe(PrescriberObserver::class);
    }
}
