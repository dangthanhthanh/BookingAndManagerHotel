<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationMail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $view;
    public $mail;
    public $content;
    /**
     * Create a new event instance.
     */
    public function __construct(string $view, array $mail, string $content)
    {
        $this->view = $view;   
        $this->mail = $mail;   
        $this->content = $content;   
    }
}
