<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\SurahController;
use App\Http\Middleware\ValidLanguage;
use Illuminate\Support\Facades\Route;

Route::name('surahs.')
->middleware([ValidLanguage::class])
->group(function () {
    Route::get('/surahs', [SurahController::class, 'index'])->name('list');
    Route::get('/surahs/{surahId}', [SurahController::class, 'ayahs'])->name('ayahs');
    Route::get('/translators', [SurahController::class, 'translators'])->name('translators');
    Route::get('/book-categories', [BookCategoryController::class, 'index'])->name('book-category');
});