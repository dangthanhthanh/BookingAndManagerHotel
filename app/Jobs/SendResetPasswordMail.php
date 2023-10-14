<?php

namespace App\Jobs;

use App\Mail\ResetPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendResetPasswordMail implements ShouldQueue
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
        string $token, 
        string $id, 
        string $user_name)
    {
        $this -> email = $email;
        $this -> url = route('client.reset.password',['id' => $id ,'_token' => $token]);
        $this -> subject = 'Wellcome '.ucfirst($user_name).' To Booking Hotel';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('send password reset mail to'.$this->email);
        $mail = new ResetPasswordMail($this->url, $this->subject);
        Mail::to($this->email)->send($mail->build());
    }
}
