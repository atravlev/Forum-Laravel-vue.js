<?php

namespace App\Listeners;

use App\Events\ThreadRecivedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadRecivedNewReply  $event
     * @return void
     */
    public function handle(ThreadRecivedNewReply $event)
    {
        collect($event->reply->mentionedUsers())
            ->map(function ($name) {
                return User::whereName($name)->first();
            })
            ->filter()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
