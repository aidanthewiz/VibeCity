<?php

namespace Tests\Browser;

use App\Http\Controllers\PartyController;
use App\Models\JoinCode;
use App\Models\Party;
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
    public function testTwitterButtonPresent()
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
                ->assertPresent('@twitterButton');
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

    public function testDeletePartyPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the Delete Party button is present once a party is created
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/party')
                ->press('@party-button')
                ->assertPresent('@delete-party-button');
        });
    }

    public function testLeavePartyPresent()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // create a join code for the party
        $joinCode = JoinCode::create([
            'code' => 'ABCDEFGH'
        ]);

        // create a party thats open
        $party = Party::create([
            'partyCreator'=> $user->id,
            'joinCode' => $joinCode->id,
            'partyOpen' => true
        ]);

        // assemble a user
        $user2 = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the Leave Party button is present once a party is created and the user
        // is not the host
        $this->browse(function (Browser $browser) use($user2, $joinCode) {
            $browser->loginAs($user2)
                ->visit('/party')
                ->type('party_join_code', 'ABCDEFGH')
                ->press('@join-with-code-button')
                ->assertPresent('@leave-party-button');
        });
    }

    public function testKickButtonPresent()
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
                ->assertPresent('@kick-user-button');
        });
    }

    public function testHideKickButtonPresent()
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
                ->press('@kick-user-button')
                ->assertPresent('@hide-kick-user-button');
        });
    }
}
