<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public string $message;
    public int $id;
    public string $formattedTime;

    /**
     * Create a new event instance.
     */
    public function __construct(string $message, int $id, string $formattedTime)
    {
        $this->message = $message;
        $this->id = $id;
        $this->formattedTime = $formattedTime;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['privet'];
    }

    public function broadcastAs(): string
    {
        return 'chats-' . $this->id;
    }
}
