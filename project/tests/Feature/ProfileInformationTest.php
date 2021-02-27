<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_profile_information_is_available()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // call update profile info
        $component = Livewire::test(UpdateProfileInformationForm::class);

        // assert name and email are the current name and email
        $this->assertEquals($user->name, $component->state['name']);
        $this->assertEquals($user->email, $component->state['email']);
    }

    public function test_profile_information_can_be_updated()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // call update profile info
        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => 'Test Name', 'email' => 'test@example.com'])
            ->call('updateProfileInformation');

        // assert name and email updated in current user data
        $this->assertEquals('Test Name', $user->fresh()->name);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }

    public function test_profile_information_name_too_long()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // call update profile info with a long username
        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => 'Test User is the name that doesn’t end. It goes on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on until it is too big',
                'email' => 'test@example.com'])
            ->call('updateProfileInformation');

        // assert username not updated
        $this->assertNotEquals('Test User is the name that doesn’t end. It goes on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on and on until it is too big',
            $user->fresh()->name);
    }


    public function test_profile_information_email_too_long()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // call update profile info with a long email
        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => 'Test Name',
                'email' => 'testymcnotanemailisanemailthatneverendsitgoesonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonanduntiitistoobig@example.com'])
            ->call('updateProfileInformation');

        // assert email not updated
        $this->assertNotEquals('testymcnotanemailisanemailthatneverendsitgoesonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonandonanduntiitistoobig@example.com', $user->fresh()->email);
    }

    public function test_profile_information_bad_email()
    {
        // create a user
        $this->actingAs($user = User::factory()->create());

        // call update profile info with a bad email
        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => 'Test Name', 'email' => 'test'])
            ->call('updateProfileInformation');

        // assert the email not updated
        $this->assertNotEquals('test', $user->fresh()->email);
    }
}
