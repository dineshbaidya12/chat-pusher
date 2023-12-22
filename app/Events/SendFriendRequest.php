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

class SendFriendRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $id;
    public int $reqSenderId;
    public int $connectionId;
    public int $countReq;
    public string $type = 'friendrequest';
    public object $userDetails;

    /**
     * Create a new event instance.
     */
    public function __construct(int $id, int $reqSenderId, int $countReq, int $connectionId)
    {
        $this->id = $id;
        $this->connectionId = $connectionId;
        $this->countReq = $countReq;
        $this->reqSenderId = $reqSenderId;
        $this->userDetails = User::where('id', $reqSenderId)->select('id', 'name', 'username', 'profile_pic')->first();
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
