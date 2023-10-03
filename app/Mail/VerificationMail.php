<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $subject;
    /**
     * Create a new message instance.
     */
    public function __construct(string $url , string $subject)
    {
        $this->url = $url;
        $this->subject = $subject;
    }

    public function build()
    {
        Log::info('Email sent to: ' . "test_build ok + view email.pages.mail_1");
        return $this->subject($this->subject)
                    ->view('email.pages.mail_1')
                    ->with(['url' => $this->url]);
    }
}
