<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('articles', ArticleController::class);

Route::post('/articles/{article}/comments', [CommentController::class, 'store']);

Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

