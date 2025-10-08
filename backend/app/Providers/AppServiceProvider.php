<?php

namespace App\Providers;

use App\Services\ArticleService;
use App\Services\CommentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Регистрирует сервисы.
     */
    public function register(): void
    {
        //
    }

    /**
     * Загружает сервисы.
     */
    public function boot(): void
    {
        //
    }
}
