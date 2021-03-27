<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegisterPresent()
    {
        // assert the word 'register' is on the page
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Register');
        });
    }

    public function testTowersPresent()
    {
        // assert that the towers class is present, representing the tower logo
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('.towers');
        });
    }
    
    public function testTowersaPresentRegister()
    {
        // assert that the towersa class is present, representing the tower logo pt.2
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('.towersa');
        });
    }

    public function testEmailInputPresent()
    {
        // assert that the email input box id is present
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPresent('#email_input');
        });
    }

    public function testNameInputPresent()
    {
        // assert that the name input box id is present
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPresent('#name_input');
        });
    }

    public function testPasswordInputPresent()
    {
        // assert that the password input box is present
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPresent('#password_input');
        });
    }

    public function testConfirmPasswordInputPresent()
    {
        // assert that the password confirmation box id is present
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPresent('#password_confirmation');
        });
    }

    public function testRegisterButtonPresent()
    {
        // assert that the register button is present and can be clicked
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('@register-button')
                ->assertVisible('@register-button');
        });
    }

    public function testLoginLinkPresent()
    {
        // assert that the login link is visible
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('@login-link');
        });
    }

    public function testHomeLinkPresent()
    {
        // assert that the home link is visible
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('@home-link');
        });
    }

    public function testSpotifyLinkPresent()
    {
        // assert that the spotify link is visible
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('@spotify-link');
        });
    }
}
