<?php

namespace Tests\Feature;

use App\Models\Party;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PartyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that parties can be created
     *
     * @return void
     */
    public function test_party_creation()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // create a party
        Party::create([
            'partyCreator'=> $user->id
        ]);

        // assert track is in the database
        $this->assertDatabaseHas('parties', ['partyCreator' => $user->id]);
    }

    /**
     * Tests that parties can be deleted
     *
     * @return void
     */
    public function test_party_deletion()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // create a party
        $party = Party::create([
            'partyCreator'=> $user->id
        ]);

        // delete the party
        $party->delete();

        // assert party is no longer in the database
        $this->assertDatabaseMissing('parties', ['partyCreator' => $user->id]);
    }
}
