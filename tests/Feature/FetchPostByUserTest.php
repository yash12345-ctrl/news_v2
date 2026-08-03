<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchPostByUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_fetch_poll_index_as_user(): void
    {
        $admin = Admin::factory()->createQuietly();
        $user = User::factory()->createQuietly();
        $this->actingAs($user);
        $response = $this->get('/api/polls');

        $response->assertStatus(200);

        $admin->delete();
        $user->delete();
    }
}
