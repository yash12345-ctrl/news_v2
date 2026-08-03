<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_article_show_api_can_return_article(): void
    {
        $response = $this->withHeaders([
            "accept" => "application/json",
        ])
        ->withoutExceptionHandling()
        ->get('/api/articles/1');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => true,
        ]);
        // dd($response->json());
    }
}
