<?php

namespace Tests\Unit;

use App\Models\UrlShortener;
use App\Services\UrlShortenerService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerServiceCreateTest extends TestCase
{
    use RefreshDatabase;

    protected $urlShortenerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlShortenerService = app(UrlShortenerService::class);
    }

    public function test_create_shortened_url(): void
    {
        $url = 'https://www.google.com';
        $shortenedUrl = $this->urlShortenerService->createUrlShortener($url);
        $this->assertInstanceOf(UrlShortener::class, $shortenedUrl);
        $this->assertEquals($url, $shortenedUrl->original_url);
    }

    public function test_create_shortened_url_invalid_exception()
    {
        try {
            $urlInvalid = 'http.google.com';
            $this->urlShortenerService->createUrlShortener($urlInvalid);
        } catch (Exception $e) {
            $this->assertEquals('The URL provided is not valid', $e->getMessage());
        }
    }

    public function test_create_shortened_url_handles_exception()
    {
        $mock = $this->createMock(UrlShortenerService::class);
        $mock->expects($this->once())
            ->method('createUrlShortener')
            ->with('https://www.google.com')
            ->will($this->throwException(new Exception('Database error')));

        $this->app->instance(UrlShortenerService::class, $mock);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Database error');
        app(UrlShortenerService::class)->createUrlShortener('https://www.google.com');
    }
}
