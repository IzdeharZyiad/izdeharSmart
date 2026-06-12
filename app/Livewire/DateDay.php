<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class DateDay extends Component
{
    public $dateToday;
    public $day;
    public $sale;

    public function mount($sale = null)
    {
        if ($sale) {
            $this->sale = $sale;
            $this->dateToday = $this->sale->dateDay;
            $this->day = $this->sale->dayName;
        } else {
            Carbon::setLocale('ar');
            $carbon = Carbon::now('Asia/Gaza');
            $this->dateToday = $carbon->format('Y-m-d');
            $this->day = $carbon->translatedFormat('l');
        }
    }

    public function updateDateToday($value)
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::parse($value)->timezone('Asia/Gaza');
        $this->dateToday = $carbon->format('Y-m-d');
        $this->day = $carbon->translatedFormat('l');
    }

    public function render()
    {
        return view('livewire.date-day');
    }
}
