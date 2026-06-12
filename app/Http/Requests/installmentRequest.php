<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class installmentRequest extends FormRequest
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
            'firstPay' => ['required', 'numeric', 'min:0'],
            'installmentsCount' => ['required', 'numeric', 'min:1'],
            'installmentAmount' => ['min:1'],
            'intervalDays' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'firstPay.required' => 'يجب تعبئة هذا الحقل',
            'firstPay.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'firstPay.min' => 'يجب ان يكون الحقل اكبر من او يساوي 0',

            'installmentsCount.required' => 'يجب تعبئة هذا الحقل',
            'installmentsCount.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'installmentsCount.min' => 'يجب ان يكون الحقل اكبر من او يساوي 1',

            'intervalDays.required' => 'يجب تعبئة هذا الحقل',
            'intervalDays.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'intervalDays.min' => 'يجب ان يكون الحقل اكبر من او يساوي 1',

            'installmentAmount.min' => 'يجب ان يكون الحقل اكبر من او يساوي 1',
        ];
    }
}
