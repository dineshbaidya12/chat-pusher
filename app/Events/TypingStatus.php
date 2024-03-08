<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TypingStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $conversationId;
    public int $whoIsTyping;

    /**
     * Create a new event instance.
     */
    public function __construct(int $conversationId, int $whoIsTyping)
    {
        $this->conversationId = $conversationId;
        $this->whoIsTyping = $whoIsTyping;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['typing-status'];
    }

    public function broadcastAs(): string
    {
        return 'typingstatus-' . $this->conversationId;
    }
}
