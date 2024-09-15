<?php

namespace Tests\Feature\UrlShortenerService;

use App\Services\UrlShortenerService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerServiceCreateTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_shortened_url(): void
    {
        $response = $this->postJson('/api/admin/url-shortener', [
            'url' => 'https://www.google.com',
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'URL shortened successfully',
        ]);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'original_url',
            ],
        ]);
    }

    public function test_create_shortened_url_invalid_exception(): void
    {
        $response = $this->postJson('/api/admin/url-shortener', [
            'url' => 'http.google.com',
            // 'original_url' => 'http.google.com',
        ]);
        $response->assertStatus(400);
        $response->assertJson([
            'code' => 400,
            'message' => 'URL is not valid',
            'data' => null
        ]);
    }

    public function test_create_shortened_url_param_missing_exception(): void
    {
        $response = $this->postJson('/api/admin/url-shortener', [
            // 'url' => 'https://www.google.com',
        ]);
        $response->assertStatus(400);
        $response->assertJson([
            'code' => 400,
            'message' => 'URL is required',
            'data' => null
        ]);
    }

    public function test_create_shortened_url_handles_exception(): void
    {
        $this->mock(UrlShortenerService::class, function ($mock) {
            $mock->shouldReceive('createUrlShortener')->andThrow(new Exception('An unexpected error occurred'));
        });
        $response = $this->postJson('/api/admin/url-shortener', [
            'url' => 'https://www.google.com',
        ]);
        $response->assertStatus(500);
        $response->assertJson([
            'code' => 500,
            'message' => 'An unexpected error occurred',
        ]);
    }
}
