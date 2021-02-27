<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_accounts_can_be_deleted()
    {
        if (! Features::hasAccountDeletionFeatures()) {
            return $this->markTestSkipped('Account deletion is not enabled.');
        }

        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call delete user with valid password
        $component = Livewire::test(DeleteUserForm::class)
                        ->set('password', 'password')
                        ->call('deleteUser');

        // assert user deleted in database
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_before_account_can_be_deleted()
    {
        if (! Features::hasAccountDeletionFeatures()) {
            return $this->markTestSkipped('Account deletion is not enabled.');
        }

        // assemble a user
        $this->actingAs($user = User::factory()->create());

        // call delete user with wrong password in database
        Livewire::test(DeleteUserForm::class)
                        ->set('password', 'wrong-password')
                        ->call('deleteUser')
                        ->assertHasErrors(['password']);

        // assert user not deleted in database
        $this->assertNotNull($user->fresh());
    }
}
