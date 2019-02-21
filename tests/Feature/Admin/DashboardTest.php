<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class DashboardTest extends TestCase
{
    /**
     * A basic test example.
     * @group admin_dashboard
     * @return void
     */
    public function testDashboard()
    {
        $email = readline('Email Correct: ');
        $password = readline('Password Correct: ');
        $user = factory(User::class)->make([
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/admin/dashboard');
        $code = readline('2fa Code: ');

        $this->from('/admin')->post('/2fa', [
           'one_time_password' => $code
        ]);

        $this->get('admin/dashboard')->assertViewIs('dashboard.dashboard');
    }
}
