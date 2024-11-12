<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'expense_id' => $this['Id'],
            'account_name' => $this['EntityRef']['name'] ?? null,
            'type' => isset($this['Credit']) ? ($this['Credit'] ? 'Credit' : 'Debit') : 'N/A',
            'payment_method' => $this['PaymentType'] ?? null,
            'total_amount' => $this['TotalAmt'] ?? null,
            'currency_code' => $this['CurrencyRef']['value'],
            'created_at' => $this['MetaData']['CreateTime'],
        ];
    }
}
