<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'customerId'         => 'required|exists:customers,id',
            'items'              => 'required|array',
            'items.*.productId'  => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'customerId.required'         => 'Müşteri ID zorunludur.',
            'items.required'              => 'Ürün kalemleri zorunludur.',
            'items.*.productId.required'  => 'Ürün ID’si gereklidir.',
            'items.*.quantity.required'   => 'Ürün adedi gereklidir.',
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors();
        throw new HttpResponseException(
            response()->json([
                'status'=>'error',
                'message' => 'Validation failed.',
                'errors' => $errors->toArray(),
            ], 422)
        );
    }

}
