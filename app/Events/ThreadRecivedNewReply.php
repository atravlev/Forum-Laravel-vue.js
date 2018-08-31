<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ThreadRecivedNewReply
{
    use Dispatchable, SerializesModels;

    /**
     * @var \App\Reply
     */
    public $reply;

    /**
      * Create a new event instance.
      *
      * @param $reply
      */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }
}
