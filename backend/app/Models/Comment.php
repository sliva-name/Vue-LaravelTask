<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Модель комментария
 *
 * @property int $id
 * @property int $article_id
 * @property string $author
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Article $article
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * Разрешённые для массового заполнения поля
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'author',
        'text',
    ];

    /**
     * Мутатор для поля author
     * Если не указано, подставляет 'anonymous'
     *
     * @param string|null $value
     * @return void
     */
    public function setAuthorAttribute(?string $value): void
    {
        $this->attributes['author'] = $value ?: 'anonymous';
    }

    /**
     * Связь "комментарий принадлежит статье"
     *
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
