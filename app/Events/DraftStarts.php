<?php

namespace App\Events;

use App\Draft;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DraftStarts implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Draft
     */
    public $draft;

    /**
     * Create a new event instance.
     *
     * @param Draft $draft
     */
    public function __construct(Draft $draft)
    {
        $this->draft = $draft;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [
            'draft.' . $this->draft->id
        ];
    }
}
