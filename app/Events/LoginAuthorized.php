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

/**
 * This class instructs Laravel to create a a websocket for Laravel Echo to listen on.
 * When logic is successful, an 'approval-granted' notification is broadcast to the constructed channel.
 */
class LoginAuthorized  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;
    public $channel;

    /**
     * Create a new event instance.
     *
     * @param String $channel The channel name is the randomly generated nonce ID.
     */
    public function __construct(String $channel)
    {
        $this->response = 200;
        $this->channel = $channel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->channel);
    }

    /**
     * The event the broadcast publishes.
     * @return string
     */
    public function broadcastAs()
    {
        return 'approval-granted';
    }
}
