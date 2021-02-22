<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegisterPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Register');
        });
    }

    public function testTowersPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('.towers');
        });
    }

    public function testEmailInputPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPresent('#email_input');
        });
    }

    public function testNameInputPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPresent('#name_input');
        });
    }

    public function testPasswordInputPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPresent('#password_input');
        });
    }

    public function testConfirmPasswordInputPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPresent('#password_confirmation');
        });
    }

    public function testRegisterButtonPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('@register-button')
                ->assertVisible('@register-button');
        });
    }

    public function testLoginLinkPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('@login-link');
        });
    }

    public function testHomeLinkPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('@home-link');
        });
    }
}
