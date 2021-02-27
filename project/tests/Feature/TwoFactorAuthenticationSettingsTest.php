<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TwoFactorAuthenticationForm;
use Livewire\Livewire;
use Tests\TestCase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_two_factor_authentication_can_be_enabled()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());
        // set session as authenticated password
        $this->withSession(['auth.password_confirmed_at' => time()]);

        // Call TFA
        Livewire::test(TwoFactorAuthenticationForm::class)
                ->call('enableTwoFactorAuthentication');
        // grab the current user data
        $user = $user->fresh();

        // assert user has tfa and recovery codes
        $this->assertNotNull($user->two_factor_secret);
        $this->assertCount(8, $user->recoveryCodes());
    }

    public function test_recovery_codes_can_be_regenerated()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());
        // set session as authenticated password
        $this->withSession(['auth.password_confirmed_at' => time()]);

        $component = Livewire::test(TwoFactorAuthenticationForm::class)
                ->call('enableTwoFactorAuthentication')
                ->call('regenerateRecoveryCodes');
        // grab the current user data
        $user = $user->fresh();
        // call creation of new recovery codes
        $component->call('regenerateRecoveryCodes');

        // assert recover codes have been regenerated and their are 8 of them
        // assert old recovery codes are not new recovery codes
        $this->assertCount(8, $user->recoveryCodes());
        $this->assertCount(8, array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()));
    }

    public function test_two_factor_authentication_can_be_disabled()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());
        // set session as authenticated password
        $this->withSession(['auth.password_confirmed_at' => time()]);

        // call tfa
        $component = Livewire::test(TwoFactorAuthenticationForm::class)
                ->call('enableTwoFactorAuthentication');
        // grab the current user data for tfa and ensure exists
        $this->assertNotNull($user->fresh()->two_factor_secret);
        // call tfa disable
        $component->call('disableTwoFactorAuthentication');

        // assert tfa no longer exists in current user data
        $this->assertNull($user->fresh()->two_factor_secret);
    }
}
