<?php


namespace Tests\Feature;


use App\Models\Party;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JoinCodeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that the user is successfully placed in a party
     *
     * @return void
     */
    public function test_create_a_code()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // give the user a party
        Party::create([
           'partyCreator' => $user->id,
        ]);

        // get the page for the party, when the user has created a party, then get the join code
        $response = $this->get('/party/createJoinCode');

        // get the party for the user
        $usersParty = Party::where('partyCreator', $user->id)->get()->toArray();

        // assert the party has a join code
        $this->assertNotEmpty($usersParty[0]['joinCode']);
    }
}
