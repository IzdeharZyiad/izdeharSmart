<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddProductDetails extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Quantity' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'lessQuantity' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'Quantity.required' => 'يجب تعبئة هذا الحقل',
            'Quantity.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'Quantity.min' => 'يجب ان يكون الحقل اكبر من او يساوي 0',
            'sale_price.required' => 'يجب تعبئة هذا الحقل',
            'sale_price.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'sale_price.min' => 'يجب ان يكون الحقل اكبر من او يساوي 0',
            'lessQuantity.required' => 'يجب تعبئة هذا الحقل',
            'lessQuantity.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'lessQuantity.min' => 'يجب ان يكون الحقل اكبر من او يساوي 0',
        ];
    }
}
