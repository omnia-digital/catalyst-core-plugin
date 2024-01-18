<?php

use Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Route;
use OmniaDigital\CatalystCore\Livewire\UserNotifications;


Route::get('r/{url?}', function ($url) {
    return redirect($url);
})->where('url', '.*');

Route::get('login', function () {
    return redirect()->route(config('catalyst-settings.login_route'));
})->name('catalyst.login');

//Route::get('register', function () {
//    return view('catalyst::auth.register');
//})->name('register');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('notifications', UserNotifications::class)->name('notifications');
    Route::get('account', OmniaDigital\CatalystCore\Livewire\Pages\Account\Index::class)->name('account');
    Route::name('media.')->prefix('media')->group(function () {
        Route::get('/', OmniaDigital\CatalystCore\Livewire\Pages\Media\Index::class)->name('index');
    });
});

require __DIR__ . '/social/web.php';
require __DIR__ . '/jobs/web.php';
require __DIR__ . '/billing/web.php';
