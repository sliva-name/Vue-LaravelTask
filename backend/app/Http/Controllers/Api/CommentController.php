<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для работы с комментариями
 */
class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService
    ) {}

    /**
     * Добавить комментарий к статье
     *
     * @param StoreRequest $request
     * @param Article $article
     * @return JsonResponse
     */
    public function store(StoreRequest $request, Article $article): JsonResponse
    {
        $comment = $this->commentService->createForArticle($article, $request->validated());
        return response()->json(new CommentResource($comment), 201);
    }

    /**
     * Удалить комментарий
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $this->commentService->delete($comment);
        return response()->json(null, 204);
    }
}
