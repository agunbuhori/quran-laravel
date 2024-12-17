<?php

use App\Http\Controllers\SurahController;
use Illuminate\Support\Facades\Route;

Route::name('surahs.')->group(function () {
    Route::get('/surahs', [SurahController::class, 'index'])->name('list');
    Route::get('/surahs/{surahId}', [SurahController::class, 'ayahs'])->name('ayahs');
});