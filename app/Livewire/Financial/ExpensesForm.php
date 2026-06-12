<?php

namespace App\Livewire\Financial;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ExpensesForm extends Component
{
    public $type;
    public $dateToday;
    public $day;
    public $mount;
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';

    public function mount()
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::now('Asia/Gaza');
        $this->dateToday = $carbon->format('Y-m-d');
        $this->day = $carbon->translatedFormat('l');
    }

    public function updateDateToday($value)
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::parse($value)->timezone('Asia/Gaza');
        $this->dateToday = $carbon->format('Y-m-d');
        $this->day = $carbon->translatedFormat('l');
    }

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
        if ($this->type == null) {
            $this->errorMessage = 'يرجى اختيار السبب';
            $this->successMessage = '';
        } else {
            $this->validate([
                'mount' => ['required', 'numeric', 'min:0'],
            ], [
                'mount.required' => 'يجب تعبئة المبلغ',
                'mount.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
                'mount.min' => 'يجب ان يحتوي الحقل على رقم اكبر من صفر ',
            ]);

            Expense::create([
                'dateDay' => $this->dateToday,
                'dayName' => $this->day,
                'mount' => $this->mount,
                'type' => $this->type,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);

            $this->errorMessage = '';
            $this->successMessage = 'تمت الاضافة بنجاح';
        }
    }

    public function render()
    {
        return view('livewire.financial.expenses-form');
    }
}
