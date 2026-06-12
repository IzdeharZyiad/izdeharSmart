<?php

namespace App\Livewire;

use Livewire\Component;

class Flexible extends Component
{
    public $amount;
    public $remain;
    public $finalPrice;

    public function mount($finalPrice)
    {
        $this->totalPrice = $finalPrice;
    }

    public function render()
    {
        return view('livewire.flexible');
    }
}
