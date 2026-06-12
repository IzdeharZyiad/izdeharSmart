<?php

namespace App\Livewire\Advance;

use App\Models\Advance;
use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdvanceForm extends Component
{
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';
    public $dateToday;
    public $day;
    public $mount;
    public $user_id;
    public $remain;
    public $cycle_id;

    public function mount($user_id, $cycle_id)
    {
        $user = User::find($user_id);
        $this->cycle_id = $cycle_id;
        $sumAdvance = $user->advance->sum('mount');
        Carbon::setLocale('ar');
        $carbon = Carbon::now('Asia/Gaza');
        $this->dateToday = $carbon->format('Y-m-d');
        $this->day = $carbon->translatedFormat('l');
        $this->user_id = $user_id;
        $this->remain = $user->salary_amount - $sumAdvance;
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
            'dateToday' => ['date', 'before_or_equal:today'],
        ], [
            'mount.required' => 'يجب تعبئة المبلغ',
            'mount.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'mount.min' => 'يجب ان يحتوي الحقل على رقم اكبر من صفر ',
            'dateToday.before_or_equal:today' => 'هذا التاريخ لم يأتي بعد',
        ]);

        $user = User::find($this->user_id);
        if ($this->dateToday < $user->joinDate) {
            $this->successMessage = '';
            $this->errorMessage = 'هذا التاريخ قبل انضمام الموظف';
        } elseif ($this->mount > $this->remain) {
            $this->successMessage = '';
            $this->errorMessage = 'هذا المبلغ اكبر من المتبقي';
        } else {
            Advance::create([
                'date' => $this->dateToday,
                'dayName' => $this->day,
                'mount' => $this->mount,
                'user_id' => $this->user_id,
                'salary_cycle_id' => $this->cycle_id,
            ]);

            $expense = Expense::where('dateDay', $this->dateToday)->get()->first();
            if (blank($expense)) {
                Expense::create([
                    'dateDay' => $this->dateToday,
                    'dayName' => $this->day,
                    'mount' => $this->mount,
                    'type' => 'سلف',
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);
            } else {
                $expense->mount += $this->mount;
                $expense->save();
            }

            $this->successMessage = 'تمت اضافة السلفة بنجاح';
            $this->errorMessage = '';
        }
    }

    public function render()
    {
        return view('livewire.advance.advance-form');
    }
}
