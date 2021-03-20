<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that comments can be created
     *
     * @return void
     */
    public function test_comment_creation()
    {
        // create a track that will be commented on
        $track = Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // create a user that will comment on
        $user = User::factory()->create();

        // create a comment for the track
        $comment = Comment::create([
            'user_id' => $user->id,
            'track_id' => $track->id,
            'content' => 'I love this track more than my child',
        ]);

        // assert comment is in the databasse
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    /**
     * Tests that comments can be deleted
     *
     * @return void
     */
    public function test_comment_deletion()
    {
        // create a track that will be commented on
        $track = Track::create([
            'name' => 'TestyMcTestTract',
            'artist' => 'TestyMcTestRapper',
        ]);

        // create a user that will comment on
        $user = User::factory()->create();

        // create a comment for the track
        $comment = Comment::create([
            'user_id' => $user->id,
            'track_id' => $track->id,
            'content' => 'I love this track more than my child',
        ]);

        // delete the rating
        $comment->delete();

        // assert comment is no longer in the database
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
