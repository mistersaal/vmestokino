<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $roomId;
    private $password;
    public $message;

    public function __construct(int $roomId, string $password, string $text, Authenticatable $user)
    {
        $this->password = $password;
        $this->roomId = $roomId;
        $this->message = compact('text', 'user');
    }

    public function broadcastOn()
    {
        return new PresenceChannel('room.player.' . $this->roomId . '.' . $this->password);
    }
}
