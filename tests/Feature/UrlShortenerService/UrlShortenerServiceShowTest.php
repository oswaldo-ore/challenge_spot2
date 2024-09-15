<?php

namespace Tests\Feature\UrlShortenerService;

use App\Models\UrlShortener;
use App\Services\UrlShortenerService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlShortenerServiceShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_shortened_url(): void
    {
        $urlShortener = UrlShortener::factory()->create();
        $response = $this->getJson("/api/admin/url-shortener/{$urlShortener->code}");
        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'URL found',
        ]);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'original_url',
            ],
        ]);
    }

    public function test_show_shortened_url_not_found_exception(): void
    {
        $response = $this->getJson('/api/admin/url-shortener/1');
        $response->assertStatus(400);
        $response->assertJson([
            'code' => 400,
            'message' => 'Url not found',
            'data' => null
        ]);
    }

    public function test_show_shortened_url_handles_exception(): void
    {
        $this->mock(UrlShortenerService::class, function ($mock) {
            $mock->shouldReceive('findByCode')->andThrow(new Exception('An unexpected error occurred'));
        });
        $response = $this->get('/api/admin/url-shortener');
        $response->assertStatus(500);
        $response->assertJson([
            'code' => 500,
            'message' => 'An unexpected error occurred',
        ]);
    }
}
