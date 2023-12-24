<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

use App\Contracts\Repository\UserRepositoryInterface;

class UserLoginAt
{
    /** @var \App\Contracts\Repository\UserRepositoryInterface */
    private $userRepository;
    
    /**
     * Create the event listener.
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        //

        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        //
        
        $this->userRepository->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => request()->getClientIp()
        ], $event->user->id);
    }
}
