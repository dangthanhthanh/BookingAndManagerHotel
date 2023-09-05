<?php

namespace App\Listeners;

use App\Events\VerificationRegisterMail as EventsVerificationRegisterMail;
use App\Mail\VerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificationRegisterMail
{
    /**
     * Handle the event.
     */
    public function handle(EventsVerificationRegisterMail $event): void
    {
        $verificationUrl = route('verification.verify', ['id' => $event->user->getKey(), 'hash' => sha1($event->user->getEmailForVerification())]);
        Log::info('Email sent to: ' . $event->user->email);
        Mail::to($event->user->email)->send(new VerificationMail($verificationUrl ,$event->user->user_name));
    }
}
