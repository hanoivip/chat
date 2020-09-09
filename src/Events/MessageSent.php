<?php

namespace Hanoivip\Chat\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $senderId;
    public $senderName;
    public $message;
    
    public function __construct($senderId, $senderName, $message)
    {
        $this->senderId = $senderId;
        $this->senderName = $senderName;
        $this->message = $message;
    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }
    // FUCK : de mac dinh Hanoivip\Chat\Events\MessageSent deo chay
    // pusher listener function not fired
    // here to fix..
    public function broadcastAs()
    {
        return 'test.chat';
    }
}