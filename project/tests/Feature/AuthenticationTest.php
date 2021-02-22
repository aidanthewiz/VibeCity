<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        // assemble and get login screen response
        $response = $this->get('/login');

        // assert screen status is OK
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        // assemble user
        $user = User::factory()->create();

        // get the response given an existent email and password
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // assert user gets authenticated and logs into home screen
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_invalid_email()
    {
        // assemble user
        $user = User::factory()->create();

        // get response with incorrect email
        $response = $this->post('/login', [
            'email' => 'email',
            'password' => 'password',
        ]);

        // assert user not authenticated
        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        // assemble user
        $user = User::factory()->create();

        // get response with incorrect password
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        // assert user not authenticated
        $this->assertGuest();
    }
}
