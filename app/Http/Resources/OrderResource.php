<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'time'  => $this->created_at->format('Y-m-d : g:i a'),
            'items_price' => $this->items_price,
            'taxes'             => $this->taxes,
            'delivery_fees'     => $this->delivery_fees,
            'coupon' => $this->coupon->code??null,
            'discount_coupon' => $this->coupon_discount,
            'Final_price'       => $this->Final_price,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
