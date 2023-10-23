<?php

use Illuminate\Support\Facades\Route;

Route::get('login', function () {
    return view('catalyst::auth.login');
})->name('login');


require __DIR__ . '/social/web.php';
require __DIR__ . '/billing/web.php';
