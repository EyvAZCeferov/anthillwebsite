<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageElements;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $messageelement;

    public function __construct(MessageElements $messageelement)
    {
        $this->messageelement = $messageelement;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('chat.' . $this->messageelement->message_group_id),
            new PrivateChannel('chats')
        ];

    }
}
