<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $receiver_id;
    public $type;
    public function __construct(public Message $message, $type = 'user')
    {
        $this->receiver_id = $message->receiver_id;
        $this->type = $type;
    }

    public function broadcastOn(): array
    {
        return [
            'messages.'.$this->type.'.'.$this->receiver_id,
        ];
    }
}
