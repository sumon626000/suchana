<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'login']);

Route::get('/courses', [ApiController::class, 'courses']);
Route::get('/notices', [ApiController::class, 'notices']);

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/stats', [ApiController::class, 'adminStats']);
    Route::get('/applications', [ApiController::class, 'applications']);
});
