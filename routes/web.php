<?php
declare(strict_types=1);

use App\Http\Controllers\SwaggerController;
use Illuminate\Support\Facades\Route;

Route::get('/swagger', [SwaggerController::class, 'index'])->name('swagger');
Route::get('/swagger/openapi.yaml', [SwaggerController::class, 'openapi'])->name('openapi');

Route::get('/', static function () {
    return view('welcome');
});
