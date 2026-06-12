<?php

namespace App\Livewire\Seller;

use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateSeller extends Component
{
    public $open = true;
    public $errorMessage = '';
    public $successMessage = '';
    public $name;
    public $idNumber;
    public $phoneNumber;
    public $balance;
    public $seller;

    public function mount($sellerId)
    {
        $this->seller = Seller::find($sellerId);
        $this->name = $this->seller->name;
        $this->idNumber = $this->seller->idNumber;
        $this->phoneNumber = $this->seller->phoneNumber;
        $this->balance = $this->seller->balance;
    }

    public function updateSeller()
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
                'phoneNumber.regex' => 'الرجاء كتابة رقم الهاتف بشكل صحيح',
                'name.required' => 'يجب تعبئة هذا الحقل',
                'idNumber.required' => 'يجب تعبئة هذا الحقل',
                'idNumber.numeric' => 'يجب ان يحتوي الحقل  على  ارقام فقط',
                'idNumber.digits' => 'يجب ان يحتوي الحقل  على  9  ارقام فقط',
                'balance.required' => 'يجب تعبئة هذا الحقل',
                'balance.numeric' => 'يجب ان يحتوي  الحقل على  ارقام فقط',
            ]
        );

        $found = Seller::where(['phoneNumber' => $this->phoneNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();
        $found_idNumber = Seller::where(['idNumber' => $this->idNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();

        if ($this->seller->idNumber == $this->idNumber && $this->seller->phoneNumber == $this->phoneNumber) {
            $this->seller->name = $this->name;
            $this->seller->balance = $this->balance;
            $this->seller->save();
            $this->successMessage = 'تم التعديل بنجاح';
            $this->errorMessage = '';
        } elseif ($this->seller->idNumber != $this->idNumber && $this->seller->phoneNumber == $this->phoneNumber) {
            if (blank($found_idNumber)) {
                $this->seller->idNumber = $this->idNumber;
                $this->seller->name = $this->name;
                $this->seller->balance = $this->balance;
                $this->seller->save();
                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'رقم الهوية موجود سابقا';
                $this->successMessage = '';
            }
        } elseif ($this->seller->idNumber == $this->idNumber && $this->seller->phoneNumber != $this->phoneNumber) {
            if (blank($found)) {
                $this->seller->name = $this->name;
                $this->seller->phoneNumber = $this->phoneNumber;
                $this->seller->balance = $this->balance;
                $this->seller->save();
                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'رقم الهاتف موجود سابقا';
                $this->successMessage = '';
            }
        } else {
            if (blank($found) && blank($found_idNumber)) {
                $this->seller->phoneNumber = $this->phoneNumber;
                $this->seller->idNumber = $this->idNumber;
                $this->seller->name = $this->name;
                $this->seller->balance = $this->balance;
                $this->seller->save();
                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'لا يمكن التعديل تأكد من بياناتك';
                $this->successMessage = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.seller.update-seller');
    }
}
