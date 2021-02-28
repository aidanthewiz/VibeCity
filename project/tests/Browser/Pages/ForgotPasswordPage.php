<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForgotPasswordPage extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testFindReset()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/forgot-password')
                    ->assertSee('Reset');
        });
    }
    public function testEmailInputBoxPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/forgot-password')
                ->assertPresent('#email');
        });
    }
    public function testEmailInputButtonPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/forgot-password')
                ->assertVisible('@reset-button');
        });
    }
    public function testSeeLogo()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/forgot-password')
                ->assertVisible('@vibecity-logo');
        });
    }
}
