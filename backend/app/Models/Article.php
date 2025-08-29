<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $author
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Comment[] $comments
 */
class Article extends Model
{
    use HasFactory;

    /**
     * Разрешённые для массового заполнения поля
     *
     * @var string[]
     */
    protected $fillable = ['title', 'content', 'author'];

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
     * Связь "одна статья имеет много комментариев"
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
