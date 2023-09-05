<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReplyTheMessageForCustommerContact
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $mail;
    protected $content;
    /**
     * Create a new event instance.
     */
    public function __construct(string $mail, string $content)
    {
     $this->mail = $mail;   
     $this->content = $content;   
    }
}
