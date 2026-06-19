<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('translations/export', [TranslationController::class, 'export']);
    Route::get('translations/search', [TranslationController::class, 'search']);
    Route::apiResource('translations', TranslationController::class);
});