<?php

namespace App\Livewire;

use Livewire\Component;

class Transaction extends Component
{
    public $type;
    public $amount;
    public $remain;
    public $finalPrice;
    public $payment_type;

    public function mount($finalPrice, $payment_type)
    {
        $this->totalPrice = $finalPrice;
        $this->remain = 0;
        $this->amount = $finalPrice;
        $this->payment_type = $payment_type;
    }

    public function calculateDisCount()
    {
        if ($this->payment_type == 'كاش') {
            $this->remain = 0;
            $this->amount = $this->finalPrice;
        } else {
            $this->remain = $this->finalPrice - $this->amount;
        }
    }

    public function updateType($type)
    {
        $this->calculateDisCount();
    }

    public function updateAmount($mount)
    {
        $this->calculateDisCount();
    }

    public function render()
    {
        return view('livewire.transaction');
    }
}
