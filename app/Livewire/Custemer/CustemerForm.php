<?php

namespace App\Livewire\Custemer;

use App\Models\Custemer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustemerForm extends Component
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

        $found = Custemer::where(['phoneNumber' => $this->phoneNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();

        // معرفه اذا رقم الهوية فاضي ولا لاع
        if ($this->idNumber != null) {
            $found_idNumber = Custemer::where(['idNumber' => $this->idNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();
            if (blank($found_idNumber)) {
                if (blank($found)) {
                    Custemer::create([
                        'name' => $this->name,
                        'phoneNumber' => $this->phoneNumber,
                        'idNumber' => $this->idNumber,
                        'balance' => $this->balance,
                        'admin_id' => Auth::guard('admin')->user()->id,
                    ]);
                    $this->errorMessage = '';
                    $this->successMessage = 'تمت الاضافة بنجاح';
                } else {
                    $this->errorMessage = 'رقم الهاتف مسجل سابقا';
                    $this->successMessage = '';
                }
            } else {
                $this->errorMessage = 'رقم الهوية موجود سابقا';
                $this->successMessage = '';
            }
        } else {
            if (blank($found)) {
                Custemer::create([
                    'name' => $this->name,
                    'phoneNumber' => $this->phoneNumber,
                    'idNumber' => $this->idNumber,
                    'balance' => $this->balance,
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);
                $this->errorMessage = '';
                $this->successMessage = 'تمت الاضافة بنجاح';
            } else {
                $this->errorMessage = 'رقم الهاتف مسجل سابقا';
                $this->successMessage = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.custemer.custemer-form');
    }
}
