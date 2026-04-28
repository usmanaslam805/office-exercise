<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Exercise\Exercise01Controller;
use App\Http\Controllers\Exercise\Exercise02Controller;

Route::withoutMiddleware('web')->group(function () {
    Route::post('exercise-1-artwork-version', [Exercise01Controller::class, 'post']);
    Route::post('exercise-2-tier-pricing', [Exercise02Controller::class, 'post']);
});
