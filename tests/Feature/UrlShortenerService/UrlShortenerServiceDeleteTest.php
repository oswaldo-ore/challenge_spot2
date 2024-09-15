<?php

namespace Tests\Feature\UrlShortenerService;

use App\Models\UrlShortener;
use App\Services\UrlShortenerService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlShortenerServiceDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_shortened_url(): void
    {
        $UrlShortener = UrlShortener::factory()->create();
        $response = $this->deleteJson("/api/admin/url-shortener/{$UrlShortener->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'URL deleted successfully',
            'data' => null
        ]);
    }

    public function test_delete_shortened_url_not_found_exception(): void
    {
        $response = $this->deleteJson('/api/admin/url-shortener/0');
        $response->assertStatus(400);
        $response->assertJson([
            'code' => 400,
            'message' => 'Url not found',
            'data' => null
        ]);
    }

    public function test_delete_shortened_url_handles_exception(): void
    {
        $this->mock(UrlShortenerService::class, function ($mock) {
            $mock->shouldReceive('findById')->andThrow(new Exception('An unexpected error occurred'));
        });
        $response = $this->delete('/api/admin/url-shortener/1');
        $response->assertStatus(500);
        $response->assertJson([
            'code' => 500,
            'message' => 'An unexpected error occurred',
        ]);
    }
}
