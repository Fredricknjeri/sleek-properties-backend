<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

Route::apiResource('properties', PropertyController::class);

