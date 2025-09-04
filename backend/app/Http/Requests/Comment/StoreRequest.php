<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Валидация для создания комментария
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
            'author' => 'nullable|string|max:100',
            'text' => 'required|string',
        ];
    }
}
