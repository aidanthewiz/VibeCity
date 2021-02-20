<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationScreenRenders()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewUsersCanRegister()
    {
        // assemble correct user information
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemail@example.com',
            'password' => 'impenetrableA1!',
            'password_confirmation' => 'impenetrableA1!',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert and validate success via authentication and page redirects to home
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testNotAnEmail()
    {
        // assemble user input with an incorrect email that doesnt have a domain
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemail',
            'password' => 'impenetrableA1!',
            'password_confirmation' => 'impenetrableA1!',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }

    public function testEmailTooLong()
    {
        // assemble user input with incorrect email that is too long
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemailisanemailthatneverendsitgoesonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonanduntiitistoobig@example.com',
            'password' => 'impenetrableA1!',
            'password_confirmation' => 'impenetrableA1!',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }

    public function testNameTooLong()
    {
        // assemble user input with too long name
        $response = $this->post('/register', [
            'name' => 'Test User is the name that doesn’t end. It goes on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on until it is too big',
            'email' => 'Testing Testerson',
            'password' => 'impenetrableA1!',
            'password_confirmation' => 'impenetrableA1!',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }

    public function testDifferentPasswordConfirmation()
    {
        // assemble user input with a different password in confirmation from the original
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemail@example.com',
            'password' => 'impenetrableA1!',
            'password_confirmation' => 'infinite22FAILS!',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }

    public function testPasswordTooShort()
    {
        // assemble user input with a password that is too short
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemail@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }

    public function testPasswordTooLong()
    {
        // assemble user input with a password that is too long
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemail@example.com',
            'password' => 'impenetrableA1!isthepasswordthatneverendsitgoesonandonandonandonandonandonandonandonandonandonandonandonandonuntilitistoolong',
            'password_confirmation' => 'impenetrableA1!isthepasswordthatneverendsitgoesonandonandonandonandonandonandonandonandonandonandonandonandonuntilitistoolong',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }

    public function testPasswordNoUppercase()
    {
        // assemble user input with a password that has no uppercase letters
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemail@example.com',
            'password' => 'impenetrable1!',
            'password_confirmation' => 'impenetrable1!',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }

    public function testPasswordNoLowercase()
    {
        // assemble user input with a password that has no lower case characters
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemail@example.com',
            'password' => 'IMPENETRABLEA1!',
            'password_confirmation' => 'IMPENETRABLEA1!',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }

    public function testPasswordNoSymbol()
    {
        // assemble user input with a password that has no symbols
        $response = $this->post('/register', [
            'name' => 'Testing Testerson',
            'email' => 'testymcnotanemail@example.com',
            'password' => 'impenetrableA1',
            'password_confirmation' => 'impenetrableA1',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // assert not authenticated as a user and that a redirect to the homepage didnt happen
        $this->assertGuest();
    }
}
