<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Валидация для создания статьи
 */
class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'nullable|string|max:100',
        ];
    }
}
