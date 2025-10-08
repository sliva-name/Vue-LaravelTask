<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

/**
 * Сервис для работы с комментариями
 */
class CommentService
{
    /**
     * Создать комментарий к статье
     *
     * @param Article $article
     * @param array $data
     * @return Model
     */
    public function createForArticle(Article $article, array $data): Model
    {
        return $article->comments()->create($data);
    }

    /**
     * Удалить комментарий
     *
     * @param Comment $comment
     * @return bool
     */
    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}

