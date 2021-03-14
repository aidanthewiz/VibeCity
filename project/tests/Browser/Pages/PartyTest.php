<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PartyTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAccessProfile()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the page header exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/party')
                ->assertSee('Party');
        });

    }

    public function testSeesInParty()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the words "In Party" present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/party')
                ->assertSee('In Party');
        });
    }

    public function testSeesCurrentSong()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the words "Current Song" are present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/party')
                ->assertSee('Current Song');
        });
    }

    public function testCreatePartyButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the Create Party button is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/party')
                ->assertPresent('@party-button');
        });
    }


    public function testClosePartyPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the Create Party button is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/party')
                ->press('@party-button')
                ->press('@join-code-button')
                ->assertPresent('@close-party-button');
        });
    }
    public function testJoinCodePresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/party')
                ->press('@party-button')
                ->assertPresent('@join-code-button');
        });
    }

    public function testJoinPartyWithCodeButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the Join Party with a code button is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/party')
                ->assertPresent('@join-with-code-button');
        });
    }
}
