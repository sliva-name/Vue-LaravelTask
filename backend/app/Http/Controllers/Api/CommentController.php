<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Добавить комментарий к статье
     *
     * @param StoreRequest $request
     * @param Article $article
     * @return JsonResponse
     */
    public function store(StoreRequest $request, Article $article): JsonResponse
    {
        $comment = $article->comments()->create($request->validated());
        return response()->json($comment, 201);
    }

    /**
     * Удалить комментарий
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();
        return response()->json(null, 204);
    }
}
