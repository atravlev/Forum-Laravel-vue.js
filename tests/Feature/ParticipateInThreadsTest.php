<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_user_can_not_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete('/replies/'.$reply->id)
            ->assertRedirect('/login');

        $this->signIn()
            ->delete('/replies/'.$reply->id)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_replies()
    {
        $this->signIn();
        
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete('/replies/'.$reply->id)->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }


    /** @test */
    public function unauthorized_user_can_not_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch('/replies/'.$reply->id)
            ->assertRedirect('/login');

        $this->signIn()
            ->patch('/replies/'.$reply->id)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $replyBody = 'You been changed, fool!';

        $this->patch("/replies/{$reply->id}", ['body' => $replyBody]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $replyBody]);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_created()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);

        $this->expectException(\Exception::class);

        $this->post($thread->path() . '/replies', $reply->toArray());
    }
}