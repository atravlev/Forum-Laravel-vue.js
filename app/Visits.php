<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    /**
     * @var \App\Thread
     */
    protected $thread;

    /**
    * Create a new instance.
    */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
    * Create a new visit record.
    */
    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    /**
    * Reset thread visits.
    */
    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    /**
    * Fetch all thread visits.
    *
    * @return integer
    */
    public function count()
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }

    /**
    * Get the cache key name.
    *
    * @return string
    */
    protected function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }
}
