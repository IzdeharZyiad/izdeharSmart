<?php

namespace App\Livewire\Seller;

use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SellerForm extends Component
{
    public $name;
    public $idNumber;
    public $phoneNumber;
    public $balance;
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';

    public function openModal()
    {
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function save()
    {
        $this->validate([
            'name' => ['required'],
            'phoneNumber' => ['required', 'numeric'],
            'idNumber' => ['nullable', 'numeric', 'digits:9'],
            'balance' => ['required', 'numeric'],
        ],
            [
                'phoneNumber.required' => 'يجب تعبئة هذا الحقل',
                'phoneNumber.numeric' => 'يجب ان يحتوي  الحقل على  ارقام فقط',
                'name.required' => 'يجب تعبئة هذا الحقل',
                'idNumber.numeric' => 'يجب ان يحتوي الحقل  على  ارقام فقط',
                'idNumber.digits' => 'يجب ان يحتوي الحقل  على  9  ارقام فقط',
                'balance.required' => 'يجب تعبئة هذا الحقل',
                'balance.numeric' => 'يجب ان يحتوي  الحقل على  ارقام فقط',
            ]
        );

        $found = Seller::where(['phoneNumber' => $this->phoneNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();

        if ($this->idNumber != null) {
            $found_idNumber = Seller::where(['idNumber' => $this->idNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();

            if (blank($found_idNumber)) {
                if (blank($found)) {
                    Seller::create([
                        'name' => $this->name,
                        'phoneNumber' => $this->phoneNumber,
                        'idNumber' => $this->idNumber,
                        'balance' => $this->balance,
                        'admin_id' => Auth::guard('admin')->user()->id,
                    ]);

                    $this->successMessage = 'تمت الاضافة بنجاح';
                    $this->errorMessage = '';
                } else {
                    $this->errorMessage = 'تم تسجيل التاجر سابقا';
                    $this->successMessage = '';
                }
            } else {
                $this->errorMessage = 'رقم الهوية مسجل سابقا';
                $this->successMessage = '';
            }
        } else {
            if (blank($found)) {
                Seller::create([
                    'name' => $this->name,
                    'phoneNumber' => $this->phoneNumber,
                    'idNumber' => $this->idNumber,
                    'balance' => $this->balance,
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);

                $this->successMessage = 'تمت الاضافة بنجاح';
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'تم تسجيل التاجر سابقا';
                $this->successMessage = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.seller.seller-form');
    }
}
