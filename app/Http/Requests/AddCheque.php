<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddCheque extends FormRequest
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
            'amount' => ['required', 'numeric', 'min:0'],
            'cheque_number' => ['required', 'numeric', 'min:0'],
            'bank_name' => ['required'],
            'chequeImg' => ['image', 'nullable'],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'يجب تعبئة هذا الحقل',
            'amount.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'amount.min' => 'يجب ان يكون الحقل اكبر من او يساوي 0',
            'cheque_number.required' => 'يجب تعبئة هذا الحقل',
            'cheque_number.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'cheque_number.min' => 'يجب ان يكون الحقل اكبر من او يساوي 0',
            'bank_name.required' => 'يجب تعبئة هذا الحقل',
            'chequeImg.image' => 'يجب ان يحتوي هذا الحقل على صورة فقط',
        ];
    }
}
