<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/social', function (Request $request) {
    return $request->user();
});
