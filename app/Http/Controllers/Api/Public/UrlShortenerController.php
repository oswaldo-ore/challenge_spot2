<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlShortenerControllerRequest;
use App\Http\Requests\UrlShortenerControllerRequestUpdate;
use App\Services\UrlShortenerService;
use App\Utils\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 *  @Oa\Info(
 *      title="URL Shortener API",
 *      version="1.0.0",
 *      description="API for URL Shortener",
 *      @OA\Contact(
 *        email="oswaldo.orellana.v@gmail.com"
 *      ),
 *  )
 */

class UrlShortenerController extends Controller
{
    protected UrlShortenerService $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/url-shortener",
     *     summary="Get list of shortened URLs with pagination",
     *     description="Returns a list of shortened URLs with pagination",
     *     tags={"URL Shortener"},
     *     @OA\Response(
     *         response=200,
     *         description="List of shortened URLs",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="List of shortened URLs"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="total", type="integer", example=100),
     *                 @OA\Property(property="data", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="code", type="string", example="xmQ27qAY"),
     *                         @OA\Property(property="original_url", type="string", example="https://www.google.com"),
     *                         @OA\Property(property="created_at", type="string", example="2024-09-14T20:54:12.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", example="2024-09-14T20:54:12.000000Z")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $data = $this->urlShortenerService->getAll();
            return ResponseHandler::success($data, 'List of shortened URLs');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getCode(), $th->getMessage(), null);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/admin/url-shortener",
     *     summary="Create a shortened URL",
     *     description="Creates a shortened URL and returns the result",
     *     tags={"URL Shortener"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url"},
     *             @OA\Property(property="url", type="string", example="https://www.google.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL shortened successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="URL shortened successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="code", type="string", example="xmQ27qAY"),
     *                 @OA\Property(property="original_url", type="string", example="https://www.google.com"),
     *                 @OA\Property(property="created_at", type="string", example="2024-09-14T20:54:12.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-09-14T20:54:12.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="message", type="string", example="URL is required"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     )
     * )
     */
    public function store(UrlShortenerControllerRequest $request)
    {
        try {
            $url = $request->url;
            $urlShortener = $this->urlShortenerService->createUrlShortener($url);
            return ResponseHandler::success($urlShortener, 'URL shortened successfully');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getCode(), $th->getMessage(), null);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/admin/url-shortener/{id}",
     *     summary="Get details of a shortened URL by ID",
     *     description="Returns the details of a shortened URL by its unique ID",
     *     tags={"URL Shortener"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The unique ID of the shortened URL",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="URL found"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="code", type="string", example="xmQ27qAY"),
     *                 @OA\Property(property="original_url", type="string", example="https://www.google.com"),
     *                 @OA\Property(property="created_at", type="string", example="2024-09-14T20:54:12.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-09-14T20:54:12.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="URL not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="message", type="string", example="URL not found"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     )
     * )
     */

    public function show($code)
    {
        try {
            $urlShortener = $this->urlShortenerService->findByCode($code);
            return ResponseHandler::success($urlShortener, 'URL found');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getCode(), $th->getMessage(), null);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/admin/url-shortener/{id}",
     *     summary="Update a shortened URL by ID",
     *     description="Updates the original URL for a shortened URL by its unique ID",
     *     tags={"URL Shortener"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The unique ID of the shortened URL",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="New URL to replace the original shortened URL",
     *         @OA\JsonContent(
     *             required={"url"},
     *             @OA\Property(property="url", type="string", example="https://www.example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="URL updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="code", type="string", example="xmQ27qAY"),
     *                 @OA\Property(property="original_url", type="string", example="https://www.example.com"),
     *                 @OA\Property(property="created_at", type="string", example="2024-09-14T20:54:12.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-09-15T12:34:56.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="URL not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="message", type="string", example="URL not found"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     )
     * )
     */
    public function update(UrlShortenerControllerRequestUpdate $request, $id)
    {
        try {
            $url = $request->input('url');
            $urlShortener = $this->urlShortenerService->updateUrlShortenerById($id, $url);
            return ResponseHandler::success($urlShortener, 'URL updated successfully');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getCode(), $th->getMessage(), null);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/admin/url-shortener/{id}",
     *     summary="Delete a shortened URL by ID",
     *     description="Deletes a shortened URL by its unique ID",
     *     tags={"URL Shortener"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The unique ID of the shortened URL",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="URL deleted successfully"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="URL not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="message", type="string", example="URL not found"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $urlShortener = $this->urlShortenerService->findById($id);
            if (!$urlShortener) {
                return ResponseHandler::error(Response::HTTP_BAD_REQUEST, 'URL not found');
            }
            $urlShortener->delete();
            return ResponseHandler::success(null, 'URL deleted successfully');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getCode(), $th->getMessage(), null);
        }
    }
}
