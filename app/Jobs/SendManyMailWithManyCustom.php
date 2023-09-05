<?php

namespace App\Jobs;

use App\Events\SendNotificationMail;
use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendManyMailWithManyCustom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    /**
     * Execute the job.
     */
    public function handle(SendNotificationMail $event)
    {
        $subject = 'Notification by Booking Hotel';
        foreach ($event->mail as $recipient) {
            Log::info('handle send mail to :'.$recipient);
            Mail::to($recipient)->send( new SendMail($event->view, $subject, $event->content));
        }
    }
}
