<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if($this->is('api/*'))
        {
            $response =  ApiResponse::sendResponse(422 , $validator->messages()->first() , $validator->messages()->all());
            throw new ValidationException($validator , $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id),],
            'address'   => ['required' , 'string']
        ];
    }
}
