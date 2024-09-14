<?php

namespace App\Repositories;

use App\Models\UrlShortener;

class UrlShortenerRepository
{
    public function findByCode(String $code)
    {
        return UrlShortener::where('code', $code)->first();
    }

    public function findById(Int $id)
    {
        return UrlShortener::find($id);
    }

    public function existsByCode(String $code)
    {
        return UrlShortener::where('code', $code)->exists();
    }

    public function generateUrlShortenerUnique(String $url)
    {
        do {
            $code = generateRandomCode();
        } while ($this->existsByCode($code));
        return $code;
    }

    public function createUrlShortener(String $url)
    {
        $code = $this->generateUrlShortenerUnique($url);
        return UrlShortener::create([
            'code' => $code,
            'original_url' => $url,
        ]);
    }

    public function updateUrlShortener(UrlShortener $urlShortener, String $url)
    {
        $urlShortener->update([
            'original_url' => $url,
        ]);
        return $urlShortener;
    }

    public function findByOriginalUrl(String $url)
    {
        return UrlShortener::where('original_url', $url)->first();
    }

    public function getAllWithPaginate()
    {
        return UrlShortener::paginate(10);
    }
}
