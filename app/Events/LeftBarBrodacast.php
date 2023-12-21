<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeftBarBrodacast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $userId;
    public int $convId;
    public string $message;
    public string $unreadMsg;
    public int $msgId;


    /**
     * Create a new event instance.
     */
    public function __construct(int $userId, int $convId, string $message, string $unreadMsg, int $msgId)
    {
        $this->userId = $userId;
        $this->convId = $convId;
        $this->message = $message;
        $this->unreadMsg = $unreadMsg;
        $this->msgId = $msgId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['public'];
    }

    public function broadcastAs(): string
    {
        return 'conv-' . $this->userId;
    }
}
