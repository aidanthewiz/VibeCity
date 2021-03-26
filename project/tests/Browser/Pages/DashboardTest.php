<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAccessDashboard()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that track is on the page
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Track');
        });
    }

    public function testRatingColumnPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the rating column exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Rating');
        });
    }

    public function testNameColumnPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the track name column exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Track Name');
        });
    }

    public function testArtistColumnPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the artist name column exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Artist');
        });
    }

    public function testArtistOrangeSectionPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the orange section is visible
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertVisible('@orange');
        });
    }

    public function testArtistRedSectionPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the red section is visible
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertVisible('@red');
        });
    }

    public function testRateButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the rate button is visible
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertVisible('@rate-track-btn');
        });
    }

    public function testLeaderboardLinkPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the leaderboard link is visible
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Leaderboard');
        });
    }

    public function testSpotifyLeaderboardLinkPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the spotify leaderboard link is visible
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Spotify Leaderboard');
        });
    }

    public function testCommentSectionPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the spotify leaderboard link is visible
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->press('@track-comments-btn')
                ->assertSee('Comments');
        });
    }

    public function testAddCommentPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the spotify leaderboard link is visible
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->press('@track-comments-btn')
                ->assertSee('Leave a Comment');
        });
    }

    public function testTweetButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the spotify leaderboard link is visible
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertPresent('@tweetButton');
        });
    }
}
