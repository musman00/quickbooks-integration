<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice_id' => $this['Id'],
            'email' => $this['BillEmail']['Address'] ?? null,
            'doc_number' => $this['DocNumber'],
            'total_amount' => $this['TotalAmt'] ?? null,
            'status' => $this['PrintStatus'],
            'current_balance' => $this['Balance'],
            'total_tax' => $this['TxnTaxDetail']['TotalTax'] ?? null,
            'currency_code' => $this['CurrencyRef']['value'],
            'due_date' => $this['DueDate'],
        ];
    }
}
