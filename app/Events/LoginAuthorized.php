<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\SerializesModels;
use const Grpc\STATUS_OK;

class LoginAuthorized  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;

    /**
     * Create a new event instance.
     *
     * @param JsonResponse $response
     */
    public function __construct()
    {
        $this->response = 200;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('auth-request');
    }

    public function broadcastAs()
    {
        return 'approval-granted';
    }
}
