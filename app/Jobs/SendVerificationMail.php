<?php

namespace App\Jobs;

use App\Mail\VerificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendVerificationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $subject;
    protected $url;
    /**
     * Create a new job instance.
     */
    public function __construct(
        string $email, 
        string $route, 
        string $token, 
        string $id, 
        string $user_name)
    {
        $this -> email = $email;
        $this -> url = route('client.'.$route.'.verification',['id' => $id ,'_token' => $token]);
        $this -> subject = 'Wellcome '.ucfirst($user_name).' To Booking Hotel';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('send mail to'.$this->email);
        $mail = new VerificationMail($this->url, $this->subject);
        Mail::to($this->email)->send($mail->build());
    }
}
