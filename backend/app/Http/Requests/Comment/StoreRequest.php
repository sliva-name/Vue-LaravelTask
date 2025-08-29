<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'author' => 'nullable|string|max:100',
            'text' => 'required|string',
        ];
    }
}
