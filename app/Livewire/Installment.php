<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class Installment extends Component
{
    public $amount;
    public $firstPay;
    public $installmentsCount;
    public $finalMount;
    public $installmentAmount;
    public $intervalDays;
    public $startDate;

    public function mount($mount)
    {
        $this->amount = $mount;
        $this->installmentsCount = 1;
        Carbon::setLocale('ar');
        $carbon = Carbon::now('Asia/Gaza');
        $this->startDate = $carbon->format('Y-m-d');
    }

    public function updateFirstPay($firstPay)
    {
        $this->calculateinstallmentAmount();
    }

    public function updateInstallmentsCount($installmentsCount)
    {
        $this->calculateinstallmentAmount();
    }

    public function calculateinstallmentAmount()
    {
        $this->finalMount = $this->amount - $this->firstPay;
        $this->installmentAmount = $this->finalMount / $this->installmentsCount;
    }

    public function render()
    {
        return view('livewire.installment');
    }
}
