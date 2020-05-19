<?php

namespace App\Events;

use App\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $roomId;
    private $password;
    public $room;

    public function __construct(int $roomId, string $password, Room $room)
    {
        $this->password = $password;
        $this->roomId = $roomId;
        $this->room = $room;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('room.player.' . $this->roomId . '.' . $this->password);
    }
}
