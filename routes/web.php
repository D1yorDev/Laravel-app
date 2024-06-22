<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'main']);

Route::get('about', [PageController::class, 'about'])->name('about');

Route::get('services', [PageController::class, 'services'])->name('services');

Route::get('projeckt', [PageController::class, 'projeck'])->name('projeck');

Route::get('blog', [PageController::class, 'blog'])->name('blog');

Route::get('signal', [PageController::class, 'signal'])->name('signal');

Route::get('contact', [PageController::class, 'contact'])->name('contact');
