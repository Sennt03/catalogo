<?php

use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::prefix('catalogo')->name('catalogo.')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('/{category:slug}', [CatalogController::class, 'category'])->name('category');
});

Route::get('/api/catalogo/producto/{product:slug}', [CatalogController::class, 'product'])->name('api.catalogo.product');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
