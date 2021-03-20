<?php

namespace Tests\Feature;

use App\Http\Controllers\JoinCodeController;
use App\Http\Controllers\PartyController;
use App\Models\JoinCode;
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

    /**
     * Tests that a user can join another user's party after it is created
     *
     * @return void
     */
    public function test_join_party()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // create a join code for the party
        $joinCode = JoinCode::create([
           'code' => 'ABCDEFGH'
        ]);

        // create a party
        $party = Party::create([
            'partyCreator'=> $user->id,
            'joinCode' => $joinCode->id,
            'partyOpen'=> true,
        ]);

        // create a second user
        $this->actingAs($user2 = User::factory()->create());

        // create a request to pass the party code as input
        $request = request();
        $request->merge([
            'party_join_code' => $joinCode->code,
        ]);

        // join the party
        PartyController::joinWithCode($request);

        // check user 2 has joined the party
        $this->assertNotNull($user2->party_id);

    }

    /**
     * Tests that a user can delete their party after it is created
     *
     * @return void
     */
    public function test_delete_party()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // create a party
        $party = Party::create([
            'partyCreator'=> $user->id,
        ]);

        // delete the party
        PartyController::deleteParty($party->id);

        // check that the party does not exist
        $this->assertDatabaseMissing('parties', ['id'=>$party->id]);
    }

    /**
     * Tests that a user can join an opened party
     *
     * @return void
     */
    public function test_join_party_when_party_open()
    {
        $this->actingAs($user = User::factory()->create());

        // create a join code for the party
        $joinCode = JoinCode::create([
            'code' => 'ABCDEFGH'
        ]);

        // create a party thats open
        $party = Party::create([
            'partyCreator'=> $user->id,
            'joinCode' => $joinCode->id,
        ]);

        PartyController::openParty($party->id);

        // create a second user
        $this->actingAs($user2 = User::factory()->create());

        // create a request to pass the party code as input
        $request = request();
        $request->merge([
            'party_join_code' => $joinCode->code,
        ]);

        // join the party
        PartyController::joinWithCode($request);

        // check user 2 has joined the party
        $this->assertNotNull($user2->party_id);
    }

    /**
     * Tests that a user cannot join a closed party
     *
     * @return void
     */
    public function test_join_party_when_party_closed()
    {
        $this->actingAs($user = User::factory()->create());

        // create a join code for the party
        $joinCode = JoinCode::create([
            'code' => 'ABCDEFGH'
        ]);

        // create a party
        $party = Party::create([
            'partyCreator'=> $user->id,
            'joinCode' => $joinCode->id,
        ]);

        PartyController::closeParty($party->id);

        // create a second user
        $this->actingAs($user2 = User::factory()->create());

        // create a request to pass the party code as input
        $request = request();
        $request->merge([
            'party_join_code' => $joinCode->code,
        ]);

        // join the party
        PartyController::joinWithCode($request);

        // check that a use cannot join a closed party
        $this->assertNull($user2->party_id);
    }

    /**
     * Tests that a user can leave a party
     *
     * @return void
     */
    public function test_leave_party()
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
        ]);

        // create second user
        $this->actingAs($user2 = User::factory()->create());

        // create a request to pass the party code as input
        $request = request();
        $request->merge([
            'party_join_code' => $joinCode->code,
        ]);

        // ensure party is open
        PartyController::openParty($party->id);

        // join the party
        PartyController::joinWithCode($request);

        // leave the party
        PartyController::leaveParty($party->id);

        // check that the user is not in a party
        $this->assertNull($user2->party_id);
    }
}
