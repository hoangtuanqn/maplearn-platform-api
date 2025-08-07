<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class PusherEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    // Tên channel phải trùng với frontend: "my-channel"
    public function broadcastOn()
    {
        return new Channel('my-channel'); // public channel
    }

    // Tên event phải trùng frontend: "my-event"
    public function broadcastAs()
    {
        return 'my-event';
    }
}
