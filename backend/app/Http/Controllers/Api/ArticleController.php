<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для работы со статьями
 */
class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleService $articleService
    ) {}

    /**
     * Получить список всех статей
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $articles = $this->articleService->getAll();
        return response()->json(ArticleResource::collection($articles));
    }

    /**
     * Получить статью по ID с комментариями
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function show(Article $article): JsonResponse
    {
        $article = $this->articleService->getWithComments($article);
        return response()->json(new ArticleResource($article));
    }

    /**
     * Создать новую статью
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $article = $this->articleService->create($request->validated());
        return response()->json(new ArticleResource($article), 201);
    }

    /**
     * Обновить существующую статью
     *
     * @param UpdateRequest $request
     * @param Article $article
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Article $article): JsonResponse
    {
        $article = $this->articleService->update($article, $request->validated());
        return response()->json(new ArticleResource($article));
    }

    /**
     * Удалить статью
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse
    {
        $this->articleService->delete($article);
        return response()->json(null, 204);
    }
}
