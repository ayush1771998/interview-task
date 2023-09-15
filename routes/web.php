<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\BallController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider and assigned to the "web" middleware group.
| Make something great!
|
*/

// Define resource routes for Balls, automatically generating CRUD routes for BallController
Route::resource('balls', BallController::class);

// Define resource routes for Buckets, automatically generating CRUD routes for BucketController
Route::resource('buckets', BucketController::class);

// Define a custom POST route for suggesting bucket allocations
Route::post('buckets/suggest', [BucketController::class, 'suggest'])->name('buckets.suggest');
