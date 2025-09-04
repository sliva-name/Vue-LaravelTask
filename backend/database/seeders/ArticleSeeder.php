<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;

/**
 * Сидер для создания тестовых статей и комментариев
 */
class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем 5 статей с комментариями
        Article::factory()
            ->count(5)
            ->has(Comment::factory()->count(rand(1, 3)))
            ->create();
    }
}
