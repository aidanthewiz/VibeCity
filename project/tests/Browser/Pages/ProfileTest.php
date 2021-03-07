<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function testAccessProfile()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the page header exists
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                    ->visit('/user/profile')
                    ->assertSee('Profile');
        });


    }

    public function testSeesProfileInfo()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the profile information section is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertSee('Name')
                ->assertSee('Email')
                ->assertSee('Profile Information');
        });


    }

    public function testSeesUpdatePassword()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the update password section is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertSee('Update Password');
        });
    }

    public function testSeeTFA()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the tfa section is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertSee('Two Factor Authentication');
        });
    }

    public function testSeeConnectedAccounts()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the connected accounts section is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertSee('Connected Accounts');
        });
    }


    public function testSeesBrowserSession()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the browser session section is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertSee('Browser Sessions');
        });
    }

    public function testSeesDeleteAccount()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the delete account section is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertSee('Permanently delete your account.');
        });
    }

    public function testNameInputPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);
        // assert that the name input is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('#name');
            $user->forceDelete();
        });
    }

    public function testEmailInputPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);
        // assert that the email input is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('#email');
            $user->forceDelete();
        });
    }

    public function testUpdatePasswordCurrentPasswordInputPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the current password input is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('#current_password_input');
            $user->forceDelete();
        });
    }

    public function testUpdatePasswordPasswordInputPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the password input is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('#password_input');
            $user->forceDelete();
        });
    }

    public function testUpdatePasswordConfirmationPasswordPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the password confirmation input is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('#password_confirmation_input');
            $user->forceDelete();
        });
    }

    public function testTFAButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the tfa button is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('@enable-tfa-btn');
        });
    }

    public function testTFAModalConfirmButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);
        // assert that the password confirm button is in the tfa modal
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->pressAndWaitFor('@enable-tfa-btn')
                ->type('conf-password-modal-input', 'test2WEB!')
                ->assertPresent('@confirm-password-btn');
        });
    }

    public function testTFAModalNevermindButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the nevermind button is in the tfa modal
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->pressAndWaitFor('@enable-tfa-btn')
                ->type('conf-password-modal-input', 'test2WEB!')
                ->assertPresent('@confirm-password-nevermind-btn');
        });
    }

    public function testConnectedAccountsConnectButton()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the connect button is in the Connected Accounts panel
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('@connect-account-link');
        });
    }

    public function testLogoutBrowserButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the logout button is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('@logout-browser-button');
        });
    }

    public function testLogoutBrowserModalConfirmButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the password confirm button is in the logout browser modal
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->pressAndWaitFor('@logout-browser-button')
                ->type('logout-browser-password-input', 'test2WEB!')
                ->assertPresent('@session-logout-confirm-btn');
        });
    }

    public function testLogoutBrowserModalNevermindButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the nevermind button is in the logout browser modal
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->pressAndWaitFor('@logout-browser-button')
                ->type('logout-browser-password-input', 'test2WEB!')
                ->assertPresent('@session-logout-nevermind-btn');
        });
    }

    public function testDeleteUserButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the delete user button is present
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->assertPresent('@delete-act-btn');
        });
    }

    public function testDeleteUserModalConfirmButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the password confirm button is in the delete user modal
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->pressAndWaitFor('@delete-act-btn')
                ->type('delete-user-password-input', 'test2WEB!')
                ->assertPresent('@delete-confirm-btn');
        });
    }

    public function testDeleteUserModalNevermindButtonPresent()
    {
        // assemble a user
        $user = User::factory(User::class)->create([
            'email' => 'testduskuser@dusk.com',
            'password' => bcrypt('test2WEB!'),
        ]);

        // assert that the nevermind button is in the delete user modal
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/user/profile')
                ->pressAndWaitFor('@delete-act-btn')
                ->type('delete-user-password-input', 'test2WEB!')
                ->assertPresent('@delete-nevermind-btn');
        });
    }
}
