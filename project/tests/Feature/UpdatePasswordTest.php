<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\UpdatePasswordForm;
use Livewire\Livewire;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call update password with valid passwords
        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password' => 'password',
                'password' => 'Password12&',
                'password_confirmation' => 'Password12&',
            ])
            ->call('updatePassword');

        // assert current user data has new password
        $this->assertTrue(Hash::check('Password12&', $user->fresh()->password));
    }

    public function test_current_password_must_be_correct()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call update password with wrong password
        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password' => 'wrong-password',
                'password' => 'new-passwordD1!',
                'password_confirmation' => 'new-passwordD1!',
            ])
            ->call('updatePassword')
            ->assertHasErrors(['current_password']);

        // assert password is still the older password in current user data
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_new_passwords_must_match()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call update password with mismatched new password
        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password' => 'password',
                'password' => 'new-passwordD1!',
                'password_confirmation' => 'wrong-passwordD1!',
            ])
            ->call('updatePassword')
            ->assertHasErrors(['password']);

        // asseert current user data still has old password
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_password_too_short()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call update user password with a password short long
        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password' => 'password',
                'password' => 'Pa1!',
                'password_confirmation' => 'Pa1!',
            ])
            ->call('updatePassword');

        // assert the password has not changed
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_password_too_long()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call update user password with a password too long
        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password' => 'password',
                'password' => 'impenetrableA1!isthepasswordthatneverendsitgoesonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonuntilitistoolong',
                'password_confirmation' => 'impenetrableA1!isthepasswordthatneverendsitgoesonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonuntilitistoolong',
            ])
            ->call('updatePassword');

        // assert the password has not changed
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_password_no_uppercase()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call update user password with a password with no uppercase
        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password' => 'password',
                'password' => 'impenetrable1!',
                'password_confirmation' => 'impenetrable1!',
            ])
            ->call('updatePassword');

        // assert the password has not changed
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }


    public function test_password_no_symbol()
    {
        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call update user password with a password with no symbols
        Livewire::test(UpdatePasswordForm::class)
            ->set('state', [
                'current_password' => 'password',
                'password' => 'impenetrableA1',
                'password_confirmation' => 'impenetrableA1!',
            ])
            ->call('updatePassword');

        // assert the password has not changed
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
