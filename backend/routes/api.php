<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;

// Маршруты для статей
Route::apiResource('articles', ArticleController::class);

// Маршруты для комментариев
Route::post('/articles/{article}/comments', [CommentController::class, 'store']);
Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

