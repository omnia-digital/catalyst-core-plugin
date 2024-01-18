<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use OmniaDigital\CatalystCore\Filament\Jobs\Pages\Home;
use OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs\JobDetail;
use OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs\MyJobs;
use OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs\NewJob;
use OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs\UpdateJob;
use OmniaDigital\CatalystCore\Filament\Jobs\Pages\Profile\Transaction;
use OmniaDigital\CatalystCore\Http\Jobs\Controllers\DownloadInvoiceController;

Route::name('filament.jobs.')->prefix('jobs')->group(function () {

    // Auth Routes
    Route::middleware([
//                'auth',
//                'verified'
    ])->group(function () {
//        Route::get('/', Home::class)->name('home');
//        Route::get('/jobs', MyJobs::class)->name('my-jobs');
//        Route::name('job.')->prefix('jobs')->group(function () {
//            Route::get('/create', NewJob::class)->name('create');
//            Route::get('/{job}/update', UpdateJob::class)->name('update');
//            Route::get('/{team:slug}/{job:slug}', JobDetail::class)->name('show');
//            Route::get('/{job:slug}', JobDetail::class)->name('single.show');
//        });

        Route::get('/user/transactions', Transaction::class)->name('profile.transactions');

        Route::get('user/invoice/{id}/download', DownloadInvoiceController::class)->name('invoice.download');
    });

});
