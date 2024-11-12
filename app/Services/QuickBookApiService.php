<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class QuickBookApiService
{
    protected PendingRequest $quickbookHttpClient;
    protected string $company_id;

    public function __construct()
    {
        $this->quickbookHttpClient = Http::quickbook();
        $this->company_id = Session::get("company_id") ?? "";
    }

    public function fetchCustomers()
    {
        $query = urlencode("SELECT * FROM Customer");

        $endpoint = "/company/{$this->company_id}/query?query={$query}";

        return $this->quickbookHttpClient->get($endpoint);
    }


    public function fetchChartOfAccounts()
    {
        $query = urlencode("SELECT * FROM Account");

        $endpoint = "/company/{$this->company_id}/query?query={$query}";

        return $this->quickbookHttpClient->get($endpoint);
    }

    public function fetchExpenses()
    {
        $query = urlencode("SELECT * FROM Purchase");

        $endpoint = "/company/{$this->company_id}/query?query={$query}";

        return $this->quickbookHttpClient->get($endpoint);
    }

    public function fetchInvoices()
    {
        $query = urlencode("SELECT * FROM Invoice");

        $endpoint = "/company/{$this->company_id}/query?query={$query}";

        return $this->quickbookHttpClient->get($endpoint);
    }

}
