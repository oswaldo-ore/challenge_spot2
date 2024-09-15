<?php

namespace Tests\Unit\UrlShortenerService;

use App\Services\UrlShortenerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerServiceDeleteTest extends TestCase
{

    use RefreshDatabase;

    protected $urlShortenerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlShortenerService = app(UrlShortenerService::class);
    }

    public function test_delete_shortened_url(): void
    {
        $url = 'https://www.google.com';
        $shortenedUrl = $this->urlShortenerService->createUrlShortener($url);
        $this->urlShortenerService->deleteById($shortenedUrl->id);
        $this->assertDatabaseMissing('url_shortener', ['id' => $shortenedUrl->id]);
    }

    public function test_delete_shortened_url_not_found_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Url not found');
        $this->urlShortenerService->deleteById(1);
    }
}
