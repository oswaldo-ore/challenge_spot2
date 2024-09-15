<?php

namespace App\Services;

use App\Repositories\UrlShortenerRepository;
use Illuminate\Http\Response;

class UrlShortenerService
{
    protected UrlShortenerRepository $urlShortenerRepository;

    public function __construct(UrlShortenerRepository $urlShortenerRepository)
    {
        $this->urlShortenerRepository = $urlShortenerRepository;
    }

    public function createUrlShortener(String $url)
    {
        validateUrl($url);
        $code = $this->urlShortenerRepository->generateUrlShortenerUnique($url);
        return $this->urlShortenerRepository->createUrlShortener($code,$url);
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

    public function findByCode(String $code)
    {
        $urlShortener = $this->urlShortenerRepository->findByCode($code);
        if ($urlShortener === null) throw new \Exception('Url not found', Response::HTTP_BAD_REQUEST);
        return $urlShortener;
    }

    public function getUrlShortenerByOriginalUrl(String $url)
    {
        $urlShortener = $this->urlShortenerRepository->findByOriginalUrl($url);
        if ($urlShortener === null) throw new \Exception('Url not found', Response::HTTP_BAD_REQUEST);
        return $urlShortener;
    }

    public function getAllWithPaginate()
    {
        return $this->urlShortenerRepository->getAllWithPaginate();
    }

    public function getAll(){
        return $this->urlShortenerRepository->getAll();
    }

    public function findById(Int $id)
    {
        $urlShortener = $this->urlShortenerRepository->findById($id);
        if ($urlShortener === null) throw new \Exception('Url not found', Response::HTTP_BAD_REQUEST);
        return $urlShortener;
    }

    public function deleteById(Int $id)
    {
        $urlShortener = $this->urlShortenerRepository->findById($id);
        if ($urlShortener === null) throw new \Exception('Url not found', Response::HTTP_BAD_REQUEST);
        $urlShortener->delete();
    }
}
