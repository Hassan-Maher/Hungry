<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'cart_price' => $this->price,
            'coupon' => $this->coupon->code??null,
            'discount_coupon' => $this->coupon_discount,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
