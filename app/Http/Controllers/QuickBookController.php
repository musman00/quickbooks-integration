<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\QuickBookApiService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

class QuickBookController extends Controller
{
    protected PendingRequest $quickBookHttpClient;

    public function __construct(
        protected QuickBookApiService $quickBookApiService
    ) {
        $this->quickBookHttpClient = Http::quickbook();
    }

    /**
     * render customers page as default page
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        try {

            return Inertia::render('Customer', [
                'data' => [],
                'success' => true,
            ]);

        } catch (\Exception $e) {
            return Inertia::render('Dashboard', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * render chart of accounts page
     *
     * @return \Inertia\Response
     */
    public function chartOfAccounts(Request $request)
    {
        try {

            return Inertia::render('ChartOfAccount', [
                'data' => [],
                'success' => true,
            ]);

        } catch (\Exception $e) {

            return Inertia::render('Dashboard', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * render invoice page
     *
     * @return \Inertia\Response
     */
    public function expenses()
    {
        try {

            return Inertia::render('Expense', [
                'data' => [],
                'success' => true,
            ]);

        } catch (\Exception $e) {

            return Inertia::render('Dashboard', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * render invoice page
     *
     * @return \Inertia\Response
     */
    public function invoices()
    {
        try {

            return Inertia::render('Invoice', [
                'data' => [],
                'success' => true,
            ]);

        } catch (\Exception $e) {

            return Inertia::render('ChartOfAccount', [
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
