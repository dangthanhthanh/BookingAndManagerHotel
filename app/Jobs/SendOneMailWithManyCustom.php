<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOneMailWithManyCustom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $view;
    protected $mail;
    protected $subject;
    protected $content;
    /**
     * Create a new job instance.
     */
    public function __construct(string $view, string $mail, string $content)
    {
        $this -> view = $view;
        $this -> mail = $mail;
        $this -> subject = 'Messenger From Booking Hotel';
        $this -> content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = new SendMail($this->view, $this->subject, $this->content);
        Mail::to($this->mail)->send($mail->build());
    }
}
