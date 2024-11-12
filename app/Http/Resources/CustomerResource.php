<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'customer_id' => $this['Id'],
            'customer_name' => $this['DisplayName'],
            'email' => $this['PrimaryEmailAddr']['Address'] ?? null,
            'phone' => $this['PrimaryPhone']['FreeFormNumber'] ?? null,
            'status' => $this['Active'],
            'current_balance' => $this['Balance'],
            'currency_code' => $this['CurrencyRef']['value'],
            'created_at' => $this['MetaData']['CreateTime'],
        ];
    }
}
