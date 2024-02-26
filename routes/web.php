<?php

use Filament\Pages\Auth\Login;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use OmniaDigital\CatalystCore\Livewire\UserNotifications;

//Auth::routes(['verify' => true]);

Route::get('r/{url?}', function ($url) {
    return redirect($url);
})->where('url', '.*');

Route::get('login', function () {
    return redirect()->route('filament.jobs.auth.login');
})->name('catalyst.login');

Route::get('register', function () {
    return redirect()->route('filament.jobs.auth.register');
})->name('catalyst.register');

Route::get('login', Login::class)->name('login');
////
//Route::get('register', Register::class)->name('register');

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
