<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return view('welcome');
});

// Properties API
// Route::apiResource('properties', PropertyController::class);