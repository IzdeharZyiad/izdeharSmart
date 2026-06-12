<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductsSwiper extends Component
{
    public $itemId = '';
    public $products = '';
    public $search = '';
    public $productId = '';

    public $open = false;

    protected $listeners = ['closeModal'];

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->products = Product::where('item_id', $this->itemId)->get();
    }

    public function updatedSearch()
    {
        $this->dispatch('refreshSwiper');
    }

    public function updateId($productId)
    {
        $this->productId = $productId;
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
        $this->productId = null;
    }

    public function render()
    {
        if ($this->search == '') {
            $this->products = Product::where('admin_id', auth()->id())
         ->where('item_id', $this->itemId)
         ->get();
        }

        $this->products = Product::query()
        ->where('admin_id', Auth::guard('admin')->user()->id)
        ->where('item_id', $this->itemId)
        ->when($this->search, function ($q) {
            $q->where('name', 'like', '%'.$this->search.'%');
        })
        ->get();

        return view('livewire.products-swiper');
    }
}
