<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\LogoutOtherBrowserSessionsForm;
use Livewire\Livewire;
use Tests\TestCase;

class BrowserSessionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_other_browser_sessions_can_be_logged_out()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call logout browser with a valid password
        Livewire::test(LogoutOtherBrowserSessionsForm::class)
                ->set('password', 'password')
                ->call('logoutOtherBrowserSessions');
    }

    public function test_bad_password()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call logout browser with invalid password
        Livewire::test(LogoutOtherBrowserSessionsForm::class)
            ->set('password', 'not the password')
            ->call('logoutOtherBrowserSessions')
            ->assertHasErrors(['password']);
    }
}
