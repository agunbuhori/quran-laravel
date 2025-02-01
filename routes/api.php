<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\CobaController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\MosqueController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\UstadzController;
use App\Http\Middleware\ValidLanguage;
use Illuminate\Support\Facades\Route;

Route::name('surahs.')
->middleware([ValidLanguage::class])
->group(function () {
    Route::get('/surahs', [SurahController::class, 'index'])->name('list');
    Route::get('/surahs/{surahId}', [SurahController::class, 'ayahs'])->name('ayahs');
    Route::get('/translators', [SurahController::class, 'translators'])->name('translators');
    Route::get('/book-categories', [BookCategoryController::class, 'index'])->name('book-category');

    Route::prefix('/file')->group(function () {
        Route::get('/tafseer/{surah}/{ayah}', [FileController::class, 'tafseer']);
        Route::put('/play_tafseer/{logId}', [FileController::class, 'play_tafseer']);
        Route::get('/youtube/{id}', [FileController::class, 'youtube']);
        Route::put('/play_youtube/{logId}', [FileController::class, 'play_youtube']);
    });

    Route::get('/learn/{tag}', [LearnController::class, 'index']);

    Route::get('/ambil-data', [CobaController::class, 'index']);
    Route::post('/login', [CobaController::class, 'login']);
    Route::post('/logout', [CobaController::class, 'logout'])->middleware('auth:api');

    Route::resource('ustadzs', UstadzController::class);
    Route::resource('mosques', MosqueController::class);

    Route::get('/telegram/requests', [TelegramController::class, 'index']);
    Route::post('/telegram/webhook', [TelegramController::class, 'webhook']);

    Route::get('/user', function () {
        return \App\Models\User::all();
    });
});