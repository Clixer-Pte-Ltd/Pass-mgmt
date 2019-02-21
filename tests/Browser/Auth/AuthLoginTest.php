<?php

namespace Tests\Browser\Auth;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthLoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group auth_2fa
     * @return void
     */
    public function testLogin2faGoogle()
    {
        $this->browse(function (Browser $browser) {
            $email = readline('Email: ');
            $password = readline('Password: ');
            $browser = $browser->visit('/admin/login')
                ->value('input[name=email]', $email)
                ->value('input[name=password]', $password)
                ->press('Login')
                ->assertPathIs('/admin/dashboard');

            $code = readline('Code: ');
            $browser->value('#one_time_password', $code)
                ->press('Verify Code')
                ->assertTitle('Dashboard :: CAG Pass Management Admin');
        });
    }
}
