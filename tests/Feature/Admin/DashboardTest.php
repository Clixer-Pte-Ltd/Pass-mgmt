<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class DashboardTest extends CrudTest
{
    /**
     * A basic test example.
     * @group admin_dashboard
     * @return void
     */
    public function testDashboard()
    {
        $this->testlogin();
        $this->get('admin/dashboard')->assertViewIs('dashboard.dashboard');
    }
}
