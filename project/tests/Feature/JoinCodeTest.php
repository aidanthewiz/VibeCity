<?php


namespace Tests\Feature;


use App\Models\JoinCode;
use App\Models\Party;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JoinCodeTest
{
    use RefreshDatabase;

    /**
     * Tests that codes can be created
     *
     * @return void
     */
    public function test_code_creation()
    {
        // create a code
        $code = 'ABC123J9';


        JoinCode::create([
            'code'=> $code
        ]);

        // assert a code is in the database
        $this->assertDatabaseHas('join_codes', ['code' => $code]);
    }

    /**
     * Tests that codes can be deleted
     *
     * @return void
     */
    public function test_code_deletion()
    {
        // create a code
        $code = 'ABC123J9';

        // create a code
        $joinCode = JoinCode::create([
            'code'=> $code
        ]);

        // delete the code
        $joinCode->delete();

        // assert the code is no longer in the database
        $this->assertDatabaseMissing('join_codes', ['code' => $code]);
    }
}

