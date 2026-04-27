<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Exercise\Exercise01Controller;

Route::withoutMiddleware('web')->group(function () {
    Route::post('exercise-1-artwork-version', [Exercise01Controller::class, 'post']);
});
