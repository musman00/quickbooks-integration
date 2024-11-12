<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChartOfAccountResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\InvoiceResource;
use App\Services\QuickBookApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class QuickBookApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected QuickBookApiService $quickBookApiService
    ) {}

    /**
     * fetch a list of customers.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchCustomers(Request $request): JsonResponse
    {
        try {
            // Fetch customers from Quickbooks API
            $customersApiResponse = $this->quickBookApiService->fetchCustomers()->json();

            // Prepare the response
            $customersResponse = CustomerResource::collection($customersApiResponse['QueryResponse']['Customer']);

            // Return success with customers
            return $this->success($customersResponse ?? []);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode() ?: 500);
        }
    }

    /**
     * fetch a list of chart of accounts.
     *
     * @return JsonResponse
     */
    public function fetchChartOfAccounts(): JsonResponse
    {
        try {
            // Fetch chart of accounts
            $chartOfAccountsApiResponse = $this->quickBookApiService->fetchChartOfAccounts()->json();

            $chartOfAccounts = ChartOfAccountResource::collection($chartOfAccountsApiResponse['QueryResponse']['Account']);

            return $this->success($chartOfAccounts ?? []);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * fetch a list of expenses
     *
     * @return JsonResponse
     */
    public function fetchExpenses(): JsonResponse
    {
        try {
            // Call Quickbooks API for fetching expenses
            $expenseApiResponse = $this->quickBookApiService->fetchExpenses()->json();

            $expenses = ExpenseResource::collection($expenseApiResponse['QueryResponse']['Purchase']);

            return $this->success($expenses ?? []);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * fetch a list of invoices.
     *
     * @return JsonResponse
     */
    public function fetchInvoices(): JsonResponse
    {
        try {
            // Call Quickbooks API for fetching invoices
            $invoiceApiResponse = $this->quickBookApiService->fetchInvoices()->json();

            $invoices = InvoiceResource::collection($invoiceApiResponse['QueryResponse']['Invoice']);

            return $this->success($invoices ?? []);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode() ?: 500);
        }
    }

}
