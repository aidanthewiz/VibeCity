<?php

namespace Tests\Feature;

use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that tracks can be created
     *
     * @return void
     */
    public function test_track_creation()
    {
        // create a track
        Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // assert track is in the databasse
        $this->assertDatabaseHas('tracks', ['name' => 'TestyMcTestTract']);
    }

    /**
     * Tests that tracks can be deleted
     *
     * @return void
     */
    public function test_track_deletion()
    {
        // create a track
        $track = Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // delete the track
        $track->delete();

        // assert track is no longer in the database
        $this->assertDatabaseMissing('tracks', ['name' => 'TestyMcTestTract']);
    }

    /**
     * Tests that tracks can be updated
     *
     * @return void
     */
    public function test_track_update()
    {
        // create a track
        $track = Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // update the track
        $track->update(['name' => 'TestTheBesty']);

        // assert track is updated in the database
        $this->assertDatabaseHas('tracks', ['name' => 'TestTheBesty']);
    }
}
