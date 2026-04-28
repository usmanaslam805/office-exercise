<?php

use App\Http\Controllers\Exercise\Exercise01Controller;
use App\Http\Controllers\Exercise\Exercise02Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('exercise-1-artwork-version', [Exercise01Controller::class, 'post']);
Route::post('exercise-2-tier-pricing', [Exercise02Controller::class, 'post']);
