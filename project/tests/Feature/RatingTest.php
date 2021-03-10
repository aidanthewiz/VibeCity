<?php

namespace Tests\Feature;

use App\Models\Rating;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that tracks can be created
     *
     * @return void
     */
    public function test_rating_creation()
    {
        // create a track that will be rated
        $track = Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // create a user that will rate
        $user = User::factory()->create();

        // create a rating for the track
        $rating = Rating::create([
            'user_id' => $user->id,
            'track_id' => $track->id,
            'rating' => 1,
        ]);

        // assert rating is in the databasse
        $this->assertDatabaseHas('ratings', ['id' => $rating->id]);
    }

    /**
     * Tests that ratings can be deleted
     *
     * @return void
     */
    public function test_rating_deletion()
    {
        // create a track that will be rated
        $track = Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // create a user that will rate
        $user = User::factory()->create();

        // create a rating for the track
        $rating = Rating::create([
            'user_id' => $user->id,
            'track_id' => $track->id,
            'rating' => 1,
        ]);

        // delete the rating
        $rating->delete();

        // assert rating is no longer in the database
        $this->assertDatabaseMissing('ratings', ['id' => $rating->id]);
    }
}
