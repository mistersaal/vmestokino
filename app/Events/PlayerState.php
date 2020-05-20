<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerState implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $roomId;
    private $password;
    public $state;

    public function __construct(int $roomId, string $password, array $state)
    {
        $this->password = $password;
        $this->roomId = $roomId;
        $this->state = $state;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('room.player.' . $this->roomId . '.' . $this->password);
    }
}
