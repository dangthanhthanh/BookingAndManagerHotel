<?php

namespace App\Listeners;

use App\Events\ResetPassword as EventsResetPassword;
use App\Mail\ResetPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResetPassword
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventsResetPassword $event)
    {
        $email = $event->email;
        $url = $event->url;
        Log::info('Email sent reset password to: ' . $email);
        Mail::to($email)->send(new ResetPasswordMail($url));
    }
}
