<?php

use App\Http\Controllers\Auth\QuickBookController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->name('quickbook-oauth.')->prefix('quickbook/oauth')->group(function () {

    Route::get('login', [QuickBookController::class, 'index'])->name('index');
    Route::get('connect', [QuickBookController::class, 'redirectToQuickBook'])->name('connect');
    Route::get('callback', [QuickBookController::class, 'handleQuickBookCallback'])->name('callback');
    Route::post('logout', [QuickBookController::class, 'destroyQuickBookToken'])->name('logout');

});
