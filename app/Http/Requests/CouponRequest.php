<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $couponId = $this->route('coupon')?->id;
        return [
            'code' => 'required|string|unique:coupons,code,' . $couponId,
            'type' => 'required|in:precentage,fixed',
            'discount_value' => 'required|numeric',
            'max_uses' => 'nullable|integer',
            'expires_at' => 'nullable|date',
            'status' => 'required|in:active,in_active',
        ];
    }
}
