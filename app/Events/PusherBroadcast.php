<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public string $message;
    public int $id;
    public string $formattedTime;
    public string $forward;
    public int $messageId;
    public object $messagedata;

    /**
     * Create a new event instance.
     */
    public function __construct(string $message, int $id, string $formattedTime, int $messageId, string $forward = 'false')
    {
        $this->messageId = $messageId;
        $this->messagedata = Message::find($messageId);
        $this->message = $message;
        $this->forward = $forward;
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
