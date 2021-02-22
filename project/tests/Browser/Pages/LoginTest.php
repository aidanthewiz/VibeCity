<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('LOGIN');
        });
    }

    public function testTowersPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertVisible('.towers');
        });
    }

    public function testEmailInputPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertPresent('#email_input');
        });
    }

    public function testPasswordInputPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertPresent('#password_input');
        });
    }

    public function testLoginButtonPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->click('@login-button')
                ->assertVisible('@login-button');
        });
    }

    public function testRegisterLinkPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertVisible('@password-link');
        });
    }

    public function testHomeLinkPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertVisible('@home-link');
        });
    }
}
