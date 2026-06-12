<?php

namespace App\Livewire;

use Livewire\Component;

class QuantityPrice extends Component
{
    public $quantity;
    public $price;
    public $totalPrice;

    public function mount($quantity = null, $price = null, $totalPrice = null)
    {
        $this->quantity = $quantity ?? null;
        $this->price = $price ?? null;
        $this->totalPrice = $totalPrice ?? null;
    }

    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->totalPrice = $this->price * $this->quantity;
    }

    public function updatePrice($price)
    {
        $this->price = $price;
        $this->totalPrice = $this->price * $this->quantity;
    }

    public function render()
    {
        return view('livewire.quantity-price');
    }
}
