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

class AccesptFriendRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $acceptedUserId;
    public int $requestedUserId;
    public int $conversationId;
    public object $acceptedUserDetails;

    /**
     * Create a new event instance.
     */
    public function __construct(int $acceptedUserId, int $requestedUserId, int $conversationId)
    {
        $this->acceptedUserId = $acceptedUserId;
        $this->requestedUserId = $requestedUserId;
        $this->conversationId = $conversationId;
        $this->acceptedUserDetails = User::where('id', $acceptedUserId)->select('id', 'name', 'username', 'profile_pic')->first();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['accept-request'];
    }

    public function broadcastAs(): string
    {
        return 'userid-' . $this->requestedUserId;
    }
}
