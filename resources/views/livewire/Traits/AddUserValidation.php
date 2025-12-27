<?php

namespace App\Livewire\Traits;

class AddUserValidation
{
    // القواعد
    public static function rules(): array
    {
        return [
            'name' => ['required'],
            'idNumber' => ['required'],
            'phoneNumber' => ['required'],
            'joinDate' => ['required', 'date', 'before_or_equal:today'],
            'salary_type' => ['required'],
            'salary_amount' => ['required', 'numeric'],
            'department' => ['required'],
        ];
    }

    // الرسائل
    public static function messages(): array
    {
        return [
            'name.required' => 'هذا الحقل مطلوب',
            'idNumber.required' => 'رقم الهوية مطلوب',
            'phoneNumber.required' => 'رقم الهاتف مطلوب',
            'joinDate.required' => 'تاريخ الانضمام مطلوب',
            'salary_type.required' => 'نوع الراتب مطلوب',
            'salary_amount.required' => 'المبلغ مطلوب',
            'salary_amount.numeric' => 'المبلغ يجب أن يكون رقم',
            'department.required' => 'القسم مطلوب',
        ];
    }
}
