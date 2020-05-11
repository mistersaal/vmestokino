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

class PlayerBuffering implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $roomId;
    private $password;
    public $currentTime;

    public function __construct(int $roomId, string $password, float $currentTime)
    {
        $this->password = $password;
        $this->roomId = $roomId;
        $this->currentTime = $currentTime;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('room.player.' . $this->roomId . '.' . $this->password);
    }
}
