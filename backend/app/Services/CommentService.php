<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Comment;

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
     * @return Comment
     */
    public function createForArticle(Article $article, array $data): Comment
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

