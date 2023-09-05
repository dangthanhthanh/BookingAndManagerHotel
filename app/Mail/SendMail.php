<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public  $view;
    public  $subject;
    public  $content;

    /**
     * Create a new message instance.
     *
     * @param string $view
     * @param string $subject
     * @param string $content
     */
    public function __construct( $view , $subject,  $content)
    {
        $this->view = $view;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view) // Replace with your email template view
            ->subject($this->subject)
            ->with(['content' => $this->content]);
    }
}
