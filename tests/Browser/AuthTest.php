<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_register_correctly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'User')
                ->type('email', 'user@user.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->click('button[type="submit"]')
                ->assertSee('You are logged in')
                ->click('#navbarDropdown')
                ->clickLink('Logout')
                ->assertSee('Posts');
        });
    }

    /** @test */
    public function a_user_can_login_correctly()
    {
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Login')
                ->type('email', 'user@user.com')
                ->type('password', 'password')
                ->click('button[type="submit"]')
                ->assertSee('You are logged in');
        });
    }
}
