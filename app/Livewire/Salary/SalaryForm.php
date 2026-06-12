<?php

namespace App\Livewire\Salary;

use App\Models\Expense;
use App\Models\Salary;
use App\Models\SalaryCycle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalaryForm extends Component
{
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';
    public $dateToday;
    public $day;
    public $mount;
    public $user_id;
    public $mountDay;
    public $dateAttendance;
    public $user;
    public $mountreq;
    public $sumAdvance;
    public $cycle;
    public $cycle_id;

    public function mount($user_id, $cycle_id)
    {
        $this->user = User::find($user_id);
        $this->cycle_id = $cycle_id;
        $this->cycle = SalaryCycle::find($this->cycle_id);
        if ($this->cycle?->is_closed == 1) {
            $this->errorMessage = 'تم دفع الراتب هذا الشهر';
            $this->successMessage = '';
        } else {
            $this->sumAdvance = $this->user->advance()
            ->where('date', '>=', $this->cycle->start_date)
            ->where('date', '<', $this->cycle->end_date)
            ->sum('mount');

            Carbon::setLocale('ar');
            $carbon = Carbon::now('Asia/Gaza');
            $this->dateToday = $carbon->format('Y-m-d');
            $this->day = $carbon->translatedFormat('l');
            $this->user_id = $user_id;
            $this->mountDay = round($this->user->salary_amount / 30, 2);
            $this->dateAttendance = $this->user->attendance()
              ->where('date', '>=', $this->cycle->start_date)
               ->where('date', '<', $this->cycle->end_date)
               ->where('status', 'غياب')
               ->count();

            $this->mountreq = $this->user->salary_amount - ($this->dateAttendance * $this->mountDay) - $this->sumAdvance;
        }
    }

    public function openModal()
    {
        $this->open = true;
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function updateDateToday($value)
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::parse($value)->timezone('Asia/Gaza');
        $this->dateToday = $carbon->format('Y-m-d');
        $this->day = $carbon->translatedFormat('l');
    }

    public function save()
    {
        $this->validate([
            'mount' => ['required', 'numeric', 'min:0'],
        ],
            [
                'mount.required' => 'يجب تعبئة هذا الحقل',
                'mount.numeric' => 'يجب ان يحتوي  الحقل على  ارقام فقط',
                'mount.min' => 'يجب ان يحتوي  الحقل على  رقم اكبر من 0 ',
            ]
        );

        if (now()->lt($this->cycle->end_date)) {
            $this->errorMessage = 'لم ينته الشهر بعد';
            $this->successMessage = '';
        } else {
            Salary::create([
                'date' => $this->dateToday,
                'dayName' => $this->day,
                'mount' => $this->mount,
                'advanceSum' => $this->sumAdvance,
                'salaryMount' => $this->user->salary_amount,
                'DayAttendance' => $this->dateAttendance,
                'startDate' => $this->cycle->start_date,
                'endDate' => $this->cycle->end_date,
                'user_id' => $this->user_id,
                'salary_cycle_id' => $this->cycle_id,
            ]);

            SalaryCycle::create([
                'user_id' => $this->user_id,
                'start_date' => $this->cycle->end_date,
                'end_date' => Carbon::parse($this->cycle->end_date)->addMonth(),
            ]);

            $expense = Expense::where('dateDay', $this->dateToday)->get()->first();
            if (blank($expense)) {
                Expense::create([
                    'dateDay' => $this->dateToday,
                    'dayName' => $this->day,
                    'mount' => $this->mount,
                    'type' => 'رواتب',
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);
            } else {
                $expense->mount += $this->mount;
                $expense->save();
            }

            $this->cycle->is_closed = 1;
            $this->cycle->total_salary = $this->user->salary_amount;
            $this->cycle->net_salary = $this->mount;
            $this->cycle->save();

            $this->errorMessage = '';
            $this->successMessage = 'تمت الاضافة بنجاح';
        }
    }

    public function render()
    {
        return view('livewire.salary.salary-form');
    }
}
