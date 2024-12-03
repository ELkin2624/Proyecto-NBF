<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            'App\Listeners\LogAuthenticationEvents',
        ],
        Logout::class => [
            'App\Listeners\LogAuthenticationEvents',
        ],
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        Registered::class => [
            'App\Listeners\LogAuthenticationEvents',
        ],
    ];

    
    public function boot(): void
    {
        parent::boot();
    }
    
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
