<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Валидация для обновления статьи
 */
class UpdateRequest extends FormRequest
{
    /**
     * Разрешить выполнение запроса
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации
     *
     * Все поля опциональны при обновлении
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'author' => 'sometimes|string|max:100',
        ];
    }
}
