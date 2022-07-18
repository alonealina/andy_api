<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Services\NewsService;
use \Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    /**
     * @var NewsService
     */
    protected $newsService;

    /**
     * @param NewsService $newsService
     */
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->newsService->getList()
        ]);
    }

    /**
     * @param NewsRequest $request
     * @return JsonResponse
     */
    public function store(NewsRequest $request): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->newsService->store($request->validated())
        ]);
    }

    /**
     * @param NewsRequest $request
     * @param News $news
     * @return JsonResponse
     */
    public function update(NewsRequest $request, News $news): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->newsService->update($request->validated(), $news)
        ]);
    }

    /**
     * @param News $news
     * @return JsonResponse
     */
    public function destroy(News $news): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->newsService->delete($news)
        ]);
    }
}
