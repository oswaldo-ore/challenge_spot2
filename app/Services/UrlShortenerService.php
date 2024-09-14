<?php

namespace App\Services;

use App\Repositories\UrlShortenerRepository;


class UrlShortenerService
{
    protected UrlShortenerRepository $urlShortenerRepository;

    public function __construct(UrlShortenerRepository $urlShortenerRepository)
    {
        $this->urlShortenerRepository = $urlShortenerRepository;
    }

    public function createUrlShortener(String $url)
    {
        return $this->urlShortenerRepository->createUrlShortener($url);
    }

    public function updateUrlShortener(String $code, String $url)
    {
        $urlShortener = $this->urlShortenerRepository->findByCode($code);
        return $this->urlShortenerRepository->updateUrlShortener($urlShortener, $url);
    }

    public function updateUrlShortenerById(Int $id, String $url)
    {
        $urlShortener = $this->urlShortenerRepository->findById($id);
        return $this->urlShortenerRepository->updateUrlShortener($urlShortener, $url);
    }

    public function getUrlShortener(String $code)
    {
        return $this->urlShortenerRepository->findByCode($code);
    }

    public function getUrlShortenerByOriginalUrl(String $url)
    {
        return $this->urlShortenerRepository->findByOriginalUrl($url);
    }

    public function getAllWithPaginate()
    {
        return $this->urlShortenerRepository->getAllWithPaginate();
    }

    public function findById(Int $id)
    {
        return $this->urlShortenerRepository->findById($id);
    }
}
