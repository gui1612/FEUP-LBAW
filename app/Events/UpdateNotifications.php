<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateNotifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $receiver_id;
    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $receiver, string $type) {
        $this->receiver_id = $receiver->id;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['users.' . $this->receiver_id];
    }

    public function broadcastAs() {
        return 'update_notifications';
    }
}
