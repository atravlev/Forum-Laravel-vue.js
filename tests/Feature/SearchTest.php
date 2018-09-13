<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        config(['scout.driver' => 'algolia']);
    }

    /** @test */
    public function a_user_can_search_threads()
    {
        $search = 'foobar';

        create('App\Thread', [], 2);

        create('App\Thread', ['body' => "A thread with the {$search} term"], 2);

        do {
            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while (empty($results));
        
        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}
