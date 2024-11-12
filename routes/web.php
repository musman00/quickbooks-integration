<?php

use App\Http\Controllers\Api\QuickBookApiController;
use App\Http\Controllers\QuickBookController;
use App\Http\Middleware\QuickBookAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Home route
Route::get('/', function () {
    return Inertia::render('Auth/QuickBookLogin', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Group API Quickbooks routes with QuickBookAuthenticated middleware
Route::name('api.quickbook.')
    ->prefix('api/quickbook')
    ->middleware(QuickBookAuthenticated::class)
    ->group(function () {
        Route::controller(QuickBookApiController::class)->group(function () {
            Route::get('/customers', 'fetchCustomers')
                ->name('customers');

            Route::get('/chartofaccounts', 'fetchChartOfAccounts')
                ->name('chartofaccounts');

            Route::get('/chartofaccounts/invoices', 'fetchChartOfAccountsForInvoices')
                ->name('chartofaccounts.invoice');

            Route::get('/chartofaccounts/assets', 'fetchChartOfAccountsForAssets')
                ->name('chartofaccounts.asset');

            Route::get('/chartofaccounts/{accountId}/transactions', 'fetchChartOfAccountTransactions')
                ->name('chartofaccount.transactions');

            Route::get('/expenses', 'fetchExpenses')
                ->name('expenses');

            Route::get('/invoices', 'fetchInvoices')
                ->name('invoices');

            Route::get('/currencies', 'fetchCurrencies')
                ->name('currencies');

            Route::get('/invoices/{invoiceId}/receipts', 'fetchInvoiceReceipts')
                ->name('invoice.receipts');
        });
    });

// Group regular Quickbooks routes with QuickBookAuthenticated middleware
Route::name('quickbook.')
    ->prefix('quickbook')
    ->middleware(QuickBookAuthenticated::class)
    ->group(function () {
        Route::controller(QuickBookController::class)->group(function () {
            Route::get('/dashboard', 'index')
                ->name('dashboard');
            Route::get('/chartofaccounts', 'chartOfAccounts')
                ->name('chartofaccounts');
            Route::get('/expenses', 'expenses')
                ->name('expenses');
            Route::get('/invoices', 'invoices')
                ->name('invoices');
            Route::post('/store-expenses', 'storeExpense')
                ->name('store.expense');
            Route::post('/invoices', 'storeInvoice')
                ->name('invoices.store');
        });
    });

// Include Quickbooks OAuth routes
require __DIR__.'/auth.php';
