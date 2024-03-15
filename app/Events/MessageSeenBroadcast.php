<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSeenBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $id;
    public int $whoSeen;
    public int $connectionId;
    public string $type = 'messageSeen';

    /**
     * Create a new event instance.
     */
    public function __construct(int $id, int $whoSeen, int $connectionId)
    {
        $this->id = $id;
        $this->whoSeen = $whoSeen;
        $this->connectionId = $connectionId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['friend-request'];
    }

    public function broadcastAs(): string
    {
        return 'theuser-' . $this->id;
    }
}
