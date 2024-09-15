<?php

namespace Tests\Unit\UrlShortenerService;

use App\Models\UrlShortener;
use App\Services\UrlShortenerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerServiceShowTest extends TestCase
{
    use RefreshDatabase;

    protected $urlShortenerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlShortenerService = app(UrlShortenerService::class);
    }

    public function test_find_by_code_returns_shortened_url(): void
    {
        $urlShortener = UrlShortener::factory()->create();
        $shortenedUrl = $this->urlShortenerService->findByCode($urlShortener->code);
        $this->assertEquals($urlShortener->code, $shortenedUrl->code);
        $this->assertEquals($urlShortener->original_url, $shortenedUrl->original_url);
        $this->assertInstanceOf(UrlShortener::class, $shortenedUrl);
    }

    public function test_find_by_code_not_found_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Url not found');
        $this->urlShortenerService->findByCode('invalid-code');
    }

    public function test_get_url_shortener_by_original_url_returns_shortened_url(): void
    {
        $urlShortener = UrlShortener::factory()->create();
        $shortenedUrl = $this->urlShortenerService->getUrlShortenerByOriginalUrl($urlShortener->original_url);
        $this->assertEquals($urlShortener->original_url, $shortenedUrl->original_url);
        $this->assertInstanceOf(UrlShortener::class, $shortenedUrl);
    }

    public function test_get_url_shortener_by_original_url_not_found_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Url not found');
        $this->urlShortenerService->getUrlShortenerByOriginalUrl('invalid-url');
    }
}
