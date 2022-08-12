<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CreateNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var
     */
    public $type;

    /**
     * @var
     */
    public $name;

    /**
     * @var mixed
     */
    public $message;

    /**
     * @var array|mixed
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type, $data = [])
    {
        $this->type = $type;
        $this->name = Auth::user()->name;
        $this->message = __('messages.notification')[$type];
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('notification.' . Auth::user()->getAdminBranch()->id);
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'notification';
    }
}
