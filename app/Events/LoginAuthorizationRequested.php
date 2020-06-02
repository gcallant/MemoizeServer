<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginAuthorizationRequested implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $hash;
    public $email;

    /**
     * Create a new event instance.
     *
     * @param string $hash
     * @param string $email
     */
    public function __construct(string $hash, string $email)
    {
        $this->hash = $hash;
        $this->email = $email;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('auth-request');
    }

    public function broadcastAs()
    {
        return 'key-dispatched';
    }
}
