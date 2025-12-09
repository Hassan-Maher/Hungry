<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SideOptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'img'  => $this->isMethod('post')?
            'required|image|mimes:png,jpg,webp,jpeg':
            'nullable|image|mimes:png,jpg,webp,jpeg',
        ];
    }
}
