<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $subject;
    /**
     * Create a new message instance.
     */
    public function __construct(string $url, string $subject)
    {
        $this->url = $url;
        $this->subject = $subject;
    }

    public function build()
    {
        Log::info("Email sent to: test_build reset password ok");
        return $this->subject($this->subject)
                    ->view("email.pages.resetPassWord")
                    ->with(['url' => $this->url]);
    }
}
