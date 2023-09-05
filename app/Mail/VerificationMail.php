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

    protected $url;
    protected $name;
    /**
     * Create a new message instance.
     */
    public function __construct(string $url , $name = '')
    {
        $this->url = $url;
        $this->name = $name;
    }

    public function build()
    {
        Log::info('Email sent to: ' . "test_build ok");
        return $this->subject('Email Verification')
                    ->view('emails.pages.verification')
                    ->with(['verificationUrl' => $this->url, "name" => $this->name]);
    }
}
