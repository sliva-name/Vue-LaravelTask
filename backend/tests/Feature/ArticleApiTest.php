<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Функциональные тесты для API статей
 */
class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_articles_list(): void
    {
        Article::factory()->count(3)->create();

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200);
    }

    public function test_can_create_article(): void
    {
        $data = [
            'title' => 'Test Article',
            'content' => 'Test content',
            'author' => 'Test Author',
        ];

        $response = $this->postJson('/api/articles', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('articles', $data);
    }

    public function test_validates_required_fields(): void
    {
        $response = $this->postJson('/api/articles', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content']);
    }
}
