<?php

namespace Tests\Feature\UrlShortenerService;

use App\Models\UrlShortener;
use App\Services\UrlShortenerService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerServiceListTest extends TestCase
{

    use RefreshDatabase;

    public function test_list_shortened_urls(): void
    {
        UrlShortener::factory()->count(10000)->create();
        $response = $this->get('/api/admin/url-shortener');
        $response->assertStatus(200);
        $response->assertJsonCount(10000, 'data');
        $response->assertJson([
            'code' => 200,
            'message' => 'List of shortened URLs',
        ]);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'code',
                    'original_url',
                ],
            ],
        ]);
    }

    public function test_list_shortened_urls_empty(): void
    {
        $response = $this->get('/api/admin/url-shortener');
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
        $response->assertJson([
            'code' => 200,
            'message' => 'List of shortened URLs',
        ]);
        $response->assertJsonStructure([
            'data' => [],
        ]);
    }

    public function test_list_shortened_urls_error_database(): void
    {
        $this->mock(UrlShortenerService::class, function ($mock) {
            $mock->shouldReceive('getAll')->andThrow(new Exception('An unexpected error occurred'));
        });
        $response = $this->get('/api/admin/url-shortener');
        $response->assertStatus(500);
        $response->assertJson([
            'code' => 500,
            'message' => 'An unexpected error occurred',
        ]);
    }
}
