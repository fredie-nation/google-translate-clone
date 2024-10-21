<?php

use App\Http\Controllers\TranslateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TranslateController::class, 'index'])->name('translate.index');
Route::post('/translate', [TranslateController::class, 'translate'])->name('translate');