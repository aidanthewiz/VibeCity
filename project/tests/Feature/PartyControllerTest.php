<?php

namespace Tests\Feature;

use App\Models\Party;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PartyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that the party page will load
     *
     * @return void
     */
    public function test_party_loads()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // get the page
        $response = $this->get('/party');

        // assert page loads
        $response->assertStatus(200);
    }

    /**
     * Tests that the party page will redirect to login without an authorized user
     *
     * @return void
     */
    public function test_party_doesnt_load()
    {
        // assemble a user then logout
        $this->actingAs($user = User::factory()->create());
        Auth::logout();

        // get the page
        $response = $this->get('/party');

        // assert page redirects to login page
        $response->assertRedirect('/login');
    }


    /**
     * Tests that the user is successfully placed in a party
     *
     * @return void
     */
    public function test_user_put_in_party()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // get the page for the party, when the user has created a party
        $response = $this->post('/party/createParty');

        // get the party for the user
        $usersParty = Party::where('partyCreator', $user->id)->get()->toArray();


        $this->assertNotEmpty($usersParty);
    }
}
