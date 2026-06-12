<?php

namespace App\Livewire\Sale;

use Livewire\Component;

class PaymentCustemer extends Component
{
    public $payment_type;
    public $custemers;

    public function mount($custemers)
    {
        $this->payment_type = 0;
        $this->custemers = $custemers;
    }

    public function updatepaymentType($payment_type)
    {
        $this->payment_type = $payment_type;
    }

    public function render()
    {
        return view('livewire.sale.payment-custemer');
    }
}
