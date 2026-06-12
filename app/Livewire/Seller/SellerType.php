<?php

namespace App\Livewire\Seller;

use App\Models\Seller;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SellerType extends Component
{
    public $types;
    public $type_id;
    public $sellers;
    public $seller_id;

    public function mount()
    {
        $this->types = Type::where('admin_id', Auth::guard('admin')->user()->id)->get();
        $this->sellers = collect();
        $this->type_id = null;
        $this->seller_id = null;
    }

    public function updateType_id($type_id)
    {
        $this->type_id = $type_id;
        $this->sellers = Seller::where('type_id', $type_id)->get();
    }

    public function render()
    {
        return view('livewire.seller.seller-type');
    }
}
