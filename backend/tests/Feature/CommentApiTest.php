<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Функциональные тесты для API комментариев
 */
class CommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_comment(): void
    {
        $article = Article::factory()->create();
        $data = [
            'author' => 'Test Author',
            'text' => 'Test comment text',
        ];

        $response = $this->postJson("/api/articles/{$article->id}/comments", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'text' => 'Test comment text',
        ]);
    }

    public function test_validates_required_text(): void
    {
        $article = Article::factory()->create();

        $response = $this->postJson("/api/articles/{$article->id}/comments", []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['text']);
    }
}
