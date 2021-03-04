<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAccessDashboard()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the page header exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Dashboard');
        });
    }

    public function testNameColumnPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the page header exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Track Name');
        });
    }

    public function testArtistColumnPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the page header exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Artist');
        });
    }

    public function testRedBorderPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the page header exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertVisible('.border-red-500');
        });
    }

    public function testOrangeBorderPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the page header exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertVisible('.border-yellow-600');
        });
    }
}
