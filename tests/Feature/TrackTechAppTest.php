<?php

namespace Tests\Feature;

use App\Models\TrackTechApp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackTechAppTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'APP Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
        ]);
    }

    public function test_can_view_app_test_catalog(): void
    {
        TrackTechApp::create([
            'sno' => 1,
            'app_name' => 'Layman',
            'package_name' => 'layman',
            'live_version' => '2.0.1',
            'test_version' => '2.0.2',
            'status' => 'ONLINE',
        ]);

        $response = $this->actingAs($this->user)->get('/app-test');

        $response->assertStatus(200);
        $response->assertSee('APP TEST');
        $response->assertSee('Layman');
        $response->assertSee('layman');
        $response->assertSee('2.0.1');
        $response->assertSee('2.0.2');
    }
}
