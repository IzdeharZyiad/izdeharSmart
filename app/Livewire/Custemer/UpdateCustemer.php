<?php

namespace App\Livewire\Custemer;

use App\Models\Cheque;
use App\Models\Custemer;
use App\Models\InstallmentDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateCustemer extends Component
{
    public $open = true;
    public $errorMessage = '';
    public $successMessage = '';
    public $name;
    public $idNumber;
    public $phoneNumber;
    public $balance;
    public $custemer;

    public function mount($custemerId)
    {
        // 🔥 حساب المتبقي
        /*  $remaining_installment = InstallmentDetail::whereHas('installment', function ($q) use ($custemerId) {
              $q->where('installmentable_type', 'App\Models\Sale') // نفس اللي بالداتابيس
                ->whereIn('installmentable_id', function ($query) use ($custemerId) {
                    $query->select('id')
                          ->from('sales')
                          ->where('custemer_id', $custemerId);
                });
          })
    ->where('status', 'غير مدفوع')
    ->sum('amount');

          $remainingCheque = Cheque::where('chequeable_type', 'App\Models\Sale')
          ->whereIn('chequeable_id', function ($query) use ($custemerId) {
              $query->select('id')
                    ->from('sales')
                    ->where('custemer_id', $custemerId);
          })
          ->where('status', 'غير مقبوض')
          ->sum('amount');*/

        $this->custemer = Custemer::find($custemerId);
        $this->name = $this->custemer->name;
        $this->idNumber = $this->custemer->idNumber;
        $this->phoneNumber = $this->custemer->phoneNumber;
        $this->balance = $this->custemer->balance;
    }

    public function updateCustemer()
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
        $found = Custemer::where(['phoneNumber' => $this->phoneNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();
        $found_idNumber = Custemer::where(['idNumber' => $this->idNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();

        if ($this->custemer->idNumber == $this->idNumber && $this->custemer->phoneNumber == $this->phoneNumber) {
            $this->custemer->name = $this->name;
            $this->custemer->balance = $this->balance;
            $this->custemer->save();
            $this->successMessage = 'تم التعديل بنجاح';
            $this->errorMessage = '';
        } elseif ($this->custemer->idNumber != $this->idNumber && $this->custemer->phoneNumber == $this->phoneNumber) {
            if (blank($found_idNumber)) {
                $this->custemer->idNumber = $this->idNumber;
                $this->custemer->name = $this->name;
                $this->custemer->balance = $this->balance;
                $this->custemer->save();
                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'رقم الهوية موجود سابقا';
                $this->successMessage = '';
            }
        } elseif ($this->custemer->idNumber == $this->idNumber && $this->custemer->phoneNumber != $this->phoneNumber) {
            if (blank($found)) {
                $this->custemer->name = $this->name;
                $this->custemer->phoneNumber = $this->phoneNumber;
                $this->custemer->balance = $this->balance;
                $this->custemer->save();
                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'رقم الهاتف موجود سابقا';
                $this->successMessage = '';
            }
        } else {
            if (blank($found) && blank($found_idNumber)) {
                $this->custemer->phoneNumber = $this->phoneNumber;
                $this->custemer->idNumber = $this->idNumber;
                $this->custemer->name = $this->name;
                $this->custemer->balance = $this->balance;
                $this->custemer->save();
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
        return view('livewire.custemer.update-custemer');
    }
}
