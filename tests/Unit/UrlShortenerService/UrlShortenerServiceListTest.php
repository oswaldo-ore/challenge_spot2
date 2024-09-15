<?php

namespace Tests\Unit\UrlShortenerService;

use App\Models\UrlShortener;
use App\Services\UrlShortenerService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerServiceListTest extends TestCase
{
    use RefreshDatabase;

    protected $urlShortenerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlShortenerService = app(UrlShortenerService::class);
    }

    public function test_get_all_returns_shortened_urls(): void
    {
        UrlShortener::factory()->count(3)->create();
        $shortenedUrls = $this->urlShortenerService->getAll();
        $this->assertInstanceOf(Collection::class, $shortenedUrls);
        $this->assertCount(3, $shortenedUrls);
        $this->assertInstanceOf(UrlShortener::class, $shortenedUrls->first());
    }

    public function test_get_all_returns_empty_collection(): void
    {
        $shortenedUrls = $this->urlShortenerService->getAll();
        $this->assertEmpty($shortenedUrls);
    }

    public function test_get_all_handles_exception()
    {
        $this->mock(UrlShortenerService::class, function ($mock) {
            $mock->shouldReceive('getAll')
                ->once()
                ->andThrow(new Exception('Database error'));
        });

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Database error');
        app(UrlShortenerService::class)->getAll();
    }
}
