<?php

namespace Tests\Feature;

use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that the leaderboard page will load
     *
     * @return void
     */
    public function test_leaderboard_loads()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // get the page
        $response = $this->get('/dashboard');

        // assert page loads
        $response->assertStatus(200);
    }

    /**
     * Tests that the leaderboard page will redirect to login without an authorized user
     *
     * @return void
     */
    public function test_leaderboard_doesnt_load()
    {
        // assemble a user then logout
        $this->actingAs($user = User::factory()->create());
        Auth::logout();

        // get the page
        $response = $this->get('/dashboard');

        // assert page redirects to login page
        $response->assertRedirect('/login');
    }


    /**
     * Tests that tracks are loaded onto the leaderboard.
     *
     * @return void
     */
    public function test_leaderboard_loads_top_50_tracks()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // get the page for the dashboard, which also runs the top 50 population
        $response = $this->get('/dashboard');
        // get the tracks in the db
        $tracks = Track::all()->toArray();

        // assert that there are 50 tracks
        $this->assertEquals(count($tracks), 50);
    }
}
