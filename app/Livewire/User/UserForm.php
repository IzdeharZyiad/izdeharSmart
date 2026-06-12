<?php

namespace App\Livewire\User;

use App\Models\SalaryCycle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserForm extends Component
{
    public $name;
    public $dateToday;
    public $idNumber;
    public $phoneNumber;
    public $salary_amount;
    public $salary_type;
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';

    public function mount()
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::now('Asia/Gaza');
        $this->dateToday = $carbon->format('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'name' => ['required'],
            'phoneNumber' => ['required', 'numeric'],
            'idNumber' => ['nullable', 'numeric', 'digits:9'],
            'salary_amount' => ['required', 'numeric'],
            'dateToday' => ['before_or_equal:today'],
        ],
            [
                'phoneNumber.required' => 'يجب تعبئة هذا الحقل',
                'phoneNumber.numeric' => 'يجب ان يحتوي  الحقل على  ارقام فقط',
                'name.required' => 'يجب تعبئة هذا الحقل',
                'idNumber.numeric' => 'يجب ان يحتوي الحقل  على  ارقام فقط',
                'idNumber.digits' => 'يجب ان يحتوي الحقل  على  9  ارقام فقط',
                'salary_amount.required' => 'يجب تعبئة هذا الحقل',
                'salary_amount.numeric' => 'يجب ان يحتوي  الحقل على  ارقام فقط',
                'dateToday.before_or_equal' => 'هذا التاريخ لم يأتي بعد',
            ]
        );

        if ($this->salary_type == null) {
            $this->errorMessage = 'يجب اختيار طبيعة الراتب';
            $this->successMessage = '';
        } else {
            $found = User::where(['phoneNumber' => $this->phoneNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();

            // معرفه اذا رقم الهوية فاضي ولا لاع
            if ($this->idNumber != null) {
                $found_idNumber = User::where(['idNumber' => $this->idNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();
                if (blank($found_idNumber)) {
                    if (blank($found)) {
                        $user = User::create([
                            'name' => $this->name,
                            'phoneNumber' => $this->phoneNumber,
                            'idNumber' => $this->idNumber,
                            'salary_amount' => $this->salary_amount,
                            'salary_type' => $this->salary_type,
                            'joinDate' => $this->dateToday,
                            'admin_id' => Auth::guard('admin')->user()->id,
                        ]);
                        $start = Carbon::parse($user->joinDate);
                        $now = now();

                        while ($start < $now) {
                            $end = $start->copy()->addMonth();

                            SalaryCycle::create([
                                'user_id' => $user->id,
                                'start_date' => $start->copy(),
                                'end_date' => $end,
                            ]);

                            $start->addMonth();
                        }

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
                    $user = User::create([
                        'name' => $this->name,
                        'phoneNumber' => $this->phoneNumber,
                        'idNumber' => $this->idNumber,
                        'salary_amount' => $this->salary_amount,
                        'salary_type' => $this->salary_type,
                        'joinDate' => $this->dateToday,
                        'admin_id' => Auth::guard('admin')->user()->id,
                    ]);
                    $start = Carbon::parse($user->joinDate);
                    $now = now();

                    while ($start < $now) {
                        $end = $start->copy()->addMonth();

                        SalaryCycle::create([
                            'user_id' => $user->id,
                            'start_date' => $start->copy(),
                            'end_date' => $end,
                        ]);

                        $start->addMonth();
                    }

                    $this->errorMessage = '';
                    $this->successMessage = 'تمت الاضافة بنجاح';
                } else {
                    $this->errorMessage = 'رقم الهاتف مسجل سابقا';
                    $this->successMessage = '';
                }
            }
        }
    }

    public function openModal()
    {
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.user.user-form');
    }
}
