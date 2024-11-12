<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'account_id' => $this['Id'],
            'account_name' => $this['Name'],
            'fully_qualified_name' => $this['FullyQualifiedName'],
            'status' => $this['Active'],
            'account_type' => $this['AccountType'],
            'current_balance' => $this['CurrentBalance'],
            'currency_code' => $this['CurrencyRef']['value'],
            'created_at' => $this['MetaData']['CreateTime'],
        ];
    }
}
