<?php

namespace Tests\Feature;

use App\Http\Controllers\LeaderboardController;
use App\Models\Rating;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LeaderboardControllerTest extends TestCase
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
     * Tests that the spotify leaderboard page will load
     *
     * @return void
     */
    public function test_spotify_leaderboard_loads()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // get the page
        $response = $this->get('/spotifyDashboard');

        // assert page loads
        $response->assertStatus(200);
    }

    /**
     * Tests that the spotify leaderboard page will redirect to login without an authorized user
     *
     * @return void
     */
    public function test_spotify_leaderboard_doesnt_load()
    {
        // assemble a user then logout
        $this->actingAs($user = User::factory()->create());
        Auth::logout();

        // get the page
        $response = $this->get('/spotifyDashboard');

        // assert page redirects to login page
        $response->assertRedirect('/login');
    }

    /**
     * Tests that the top 50 tracks can be populated from spotify
     *
     * @return void
     */
    public function test_get_spotify_tracks()
    {
        // run function to get spotify tracks
        $tracks = LeaderboardController::getSpotifyTracks();

        // assert that there are 50 tracks from spotify
        $this->assertEquals(50, count($tracks['items']));
    }

    /**
     * Tests that the top 50 tracks can be populated from spotify
     *
     * @return void
     */
    public function test_populates_top_50_tracks()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // run populate top 50
        LeaderboardController::populateTop50();

        // get the tracks in the db
        $tracks = Track::all()->toArray();

        // assert that there are 50 tracks
        $this->assertEquals(50, count($tracks));
    }

    /**
     * Tests that predetermined top 50 tracks can be loaded from a csv
     *
     * @return void
     */
    public function test_populates_predetermined_50()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // populate tracks with predetermined top 50 from a spreadsheet
        LeaderboardController::populatePredetermined50();

        // get the tracks in the db
        $tracks = Track::all()->toArray();

        // assert that there are 50 tracks
        $this->assertEquals(50, count($tracks));
    }

    /**
     * Tests that tracks are rated when rate is called
     *
     * @return void
     */
    public function test_leaderboard_rate()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // create a track that will be rated
        $track = Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // run rate on the track
        LeaderboardController::rate($track->id);

        // assert that the track has a rating of 1
        $this->assertDatabaseHas('tracks', ['name' => 'TestyMcTestTract', 'rating' => 1]);
    }

    /**
     * Tests that tracks start out unrated
     *
     * @return void
     */
    public function test_leaderboard_tracks_unrated()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // create a track that will be rated
        Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // assert that the rating is 0
        $this->assertDatabaseHas('tracks', ['name' => 'TestyMcTestTract','rating' => 0]);
    }

    /**
     * Tests that tracks with a rating by the user are undone when rated again
     *
     * @return void
     */
    public function test_leaderboard_undo_rating()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // create a track that will be rated
        $track = Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // run rate on the track
        LeaderboardController::rate($track->id);

        // run rate on the track a second time as the same user
        LeaderboardController::rate($track->id);

        // assert that the track has only gained 1 point of rating
        $this->assertDatabaseHas('tracks', ['name' => 'TestyMcTestTract', 'rating' => 0]);
    }
}
