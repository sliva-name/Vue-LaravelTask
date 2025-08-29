<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    /**
     * Получить список всех статей
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Article::all());
    }

    /**
     * Получить статью по ID с комментариями
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $article = Article::with('comments')->findOrFail($id);
        return response()->json($article);
    }

    /**
     * Создать новую статью
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $article = Article::create($request->validated());
        return response()->json($article, 201);
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
        $article->update($request->validated());
        return response()->json($article);
    }

    /**
     * Удалить статью
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }
}
