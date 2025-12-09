<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
        return [
            'product_id'    => ['required' , 'exists:products,id'],
            'quantity'      => ['required' , 'integer' , 'min:1'],
            'toppings'      => ['nullable' , 'array'],
            'toppings.*'    => ['exists:toppings,id'],
            'side_options'   => ['nullable' , 'array'],
            'side_options.*' => ['exists:side_options,id']
        ];
    }
}
