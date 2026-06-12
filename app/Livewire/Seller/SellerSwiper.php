<?php

namespace App\Livewire\Seller;

use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SellerSwiper extends Component
{
    public $search;
    public $open = false;
    public $sellerId = '';
    protected $listeners = ['closeModal'];

    public function updatedSearch()
    {
        $this->dispatch('refreshSwiper');
    }

    public function updateId($sellerId)
    {
        $this->sellerId = $sellerId;
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
        $this->sellerId = null;
    }

    public function render()
    {
        if ($this->search == '') {
            $sellers = Seller::query()
          ->where('admin_id', Auth::guard('admin')->user()->id)
            ->get();
        }
        $sellers = Seller::query()
          ->where('admin_id', Auth::guard('admin')->user()->id)
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%');
            })
            ->get();

        return view('livewire.seller.seller-swiper', [
            'sellers' => $sellers,
        ]);
    }
}
