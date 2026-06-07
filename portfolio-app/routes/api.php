<?php

use App\Http\Controllers\Api\ShowcaseApiController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/stats', [ShowcaseApiController::class, 'getStats']);
Route::get('/v1/profile', [ShowcaseApiController::class, 'getProfile']);
