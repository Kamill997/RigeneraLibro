<?php

namespace App\Events;

use App\Models\Messaggio;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->id_mittente . '.' . $this->message->id_destinatario),
        ];
    }

    public function broadcastAs()
    {
        return 'new.message';
    }
}


/**
 * Get the channels the event should broadcast on.
 *
 * @return array<int, \Illuminate\Broadcasting\Channel>
 */
