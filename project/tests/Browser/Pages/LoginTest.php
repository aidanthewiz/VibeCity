<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginPresent()
    {
        // assert the word 'login' is on the page
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('LOGIN');
        });
    }

    public function testTowerPresent()
    {
        // assert that the towers class is present, representing the tower logo
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertVisible('.tower');
        });
    }

    public function testToweraPresentLogin()
    {
        // assert that the towersa class is present, representing the tower logo pt.2
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertVisible('.towera');
        });
    }

    public function testEmailInputPresent()
    {
        // assert that the email input box id is present
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertPresent('#email_input');
        });
    }

    public function testPasswordInputPresent()
    {
        // assert that the password input box is present
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertPresent('#password_input');
        });
    }

    public function testLoginButtonPresent()
    {
        // assert that the login button is present and can be clicked
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->click('@login-button')
                ->assertVisible('@login-button');
        });
    }

    public function testPasswordLinkPresent()
    {
        // assert that the password link is visible
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertVisible('@password-link');
        });
    }

    public function testHomeLinkPresent()
    {
        // assert that the home link is visible
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
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
