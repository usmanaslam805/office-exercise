<?php

use App\Http\Controllers\Exercise\Exercise01Controller;
use App\Http\Controllers\Exercise\Exercise02Controller;
use App\Http\Controllers\Exercise\Exercise03Controller;
use App\Http\Controllers\Exercise\Exercise04Controller;
use App\Http\Controllers\Exercise\Exercise05Controller;
use App\Http\Controllers\Exercise\Exercise06Controller;
use App\Http\Controllers\Exercise\Exercise07Controller;
use App\Http\Controllers\Exercise\Exercise08Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('exercise-1-artwork-version', [Exercise01Controller::class, 'post']);
Route::post('exercise-2-tier-pricing', [Exercise02Controller::class, 'post']);
Route::post('exercise-3-cart-validator', [Exercise03Controller::class, 'post']);
Route::post('exercise-4-vendor-allocation', [Exercise04Controller::class, 'post']);
Route::post('exercise-5-discount', [Exercise05Controller::class, 'post']);
Route::post('exercise-6-approval-flow', [Exercise06Controller::class, 'post']);
Route::post('exercise-7-inventory', [Exercise07Controller::class, 'post']);
Route::post('exercise-8-shipment', [Exercise08Controller::class, 'post']);
