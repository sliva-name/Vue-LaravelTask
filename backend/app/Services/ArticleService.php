<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

/**
 * Сервис для работы со статьями
 */
class ArticleService
{
    /**
     * Получить все статьи
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Article::all();
    }

    /**
     * Найти статью с комментариями
     *
     * @param Article $article
     * @return Article
     */
    public function getWithComments(Article $article): Article
    {
        return $article->load('comments');
    }

    /**
     * Создать статью
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        return Article::create($data);
    }

    /**
     * Обновить статью
     *
     * @param Article $article
     * @param array $data
     * @return Article
     */
    public function update(Article $article, array $data): Article
    {
        $article->update($data);
        return $article;
    }

    /**
     * Удалить статью
     *
     * @param Article $article
     * @return bool
     */
    public function delete(Article $article): bool
    {
        return $article->delete();
    }
}

