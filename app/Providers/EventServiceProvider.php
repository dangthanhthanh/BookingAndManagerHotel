<?php

namespace App\Providers;

use App\Events\NewRegister;
use App\Events\ReplyTheMessageForCustommerContact;
use App\Events\ResetPassword;
use App\Events\SendNotificationMail;
use App\Jobs\SendManyMailWithManyCustom;
use App\Jobs\SendOneMailWithManyCustom;
use App\Jobs\SendReplyCustomerContactMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        // NewRegister::class => [
        //     ::class
        // ],
        ResetPassword::class => [
            \App\Listeners\ResetPassword::class
        ],
        ReplyTheMessageForCustommerContact::class => [
            SendReplyCustomerContactMail::class
        ],
        SendNotificationMail::class => [
            SendManyMailWithManyCustom::class,
            // SendOneMailWithManyCustom::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
