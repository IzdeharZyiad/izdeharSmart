<?php

namespace App\Livewire\Sale;

use Livewire\Component;

class Discount extends Component
{
    public $disCountType;
    public $disCount;
    public $price;
    public $totalPrice;

    public function mount($totalPrice)
    {
        $this->totalPrice = $totalPrice;
        $this->price = $totalPrice;
        $this->disCount = 0;
    }

    public function calculateDisCount()
    {
        if ($this->disCountType == 'لا يوجد') {
            $this->price = $this->totalPrice;
            $this->disCount = 0;
        } elseif ($this->disCountType == 'رقم') {
            $dis = $this->totalPrice - $this->disCount;
            $this->price = $dis;
        } else {
            $dis = $this->totalPrice - ($this->totalPrice * $this->disCount);
            $this->price = $dis;
        }
    }

    public function updateDisCountType($disCountType)
    {
        $this->calculateDisCount();
    }

    public function updateDisCount($disCount)
    {
        $this->calculateDisCount();
    }

    public function render()
    {
        return view('livewire.sale.discount');
    }
}
