<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ENewsPaperTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->postJson('/api/enews', [
            'title'         => 'Test title',
            'slug'          => 'test-title',
            'category_id'   => 1,
            'admin_id'      => 1,
        ]);

        $response->assertStatus(201);

        dd($response->json());
    }
}
