<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Exercise\Exercise01Controller;
use App\Http\Controllers\Exercise\Exercise02Controller;
use App\Http\Controllers\Exercise\Exercise03Controller;
use App\Http\Controllers\Exercise\Exercise04Controller;
use App\Http\Controllers\Exercise\Exercise05Controller;
use App\Http\Controllers\Exercise\Exercise06Controller;
use App\Http\Controllers\Exercise\Exercise07Controller;
use App\Http\Controllers\Exercise\Exercise08Controller;
use App\Http\Controllers\Exercise\Exercise09Controller;
use App\Http\Controllers\Exercise\Exercise10Controller;
use App\Http\Controllers\Exercise\Exercise11Controller;
use App\Http\Controllers\Exercise\Exercise12Controller;
use App\Http\Controllers\Exercise\Exercise13Controller;
use App\Http\Controllers\Exercise\Exercise14Controller;
use App\Http\Controllers\Exercise\Exercise15Controller;
use App\Http\Controllers\Exercise\Exercise16Controller;

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
Route::post('exercise-9-webhook', [Exercise09Controller::class, 'post']);
Route::post('exercise-10-quote-expiry', [Exercise10Controller::class, 'post']);
Route::post('exercise-12-bundle-pricing', [Exercise12Controller::class, 'post']);
Route::post('exercise-11-product-visibility', [Exercise11Controller::class, 'post']);
Route::post('exercise-13-cart-merge', [Exercise13Controller::class, 'post']);
Route::post('exercise-14-upsell', [Exercise14Controller::class, 'post']);
Route::post('exercise-15-shipping-rule', [Exercise15Controller::class, 'post']);
Route::post('exercise-16-fraud-check', [Exercise16Controller::class, 'post']);

