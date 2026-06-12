<?php

namespace App\Livewire;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItemsSwiper extends Component
{
    public $search = '';
    public $itemId = '';
    public $typeId = '';
    public $items = '';
    public $open = false;

    protected $listeners = ['closeModal'];

    public function mount($typeId)
    {
        $this->typeId = $typeId;
        $this->items = Item::where('admin_id', auth()->id())
         ->where('type_id', $this->typeId)
         ->get();
    }

    public function updatedSearch()
    {
        $this->dispatch('refreshSwiper');
    }

    public function updateId($itemId)
    {
        $this->itemId = $itemId;
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
        $this->itemId = null;
    }

    public function render()
    {
        if ($this->search == '') {
            $this->items = Item::where('admin_id', auth()->id())
         ->where('type_id', $this->typeId)
         ->get();
        }

        $this->items = Item::query()
        ->where('admin_id', Auth::guard('admin')->user()->id)
         ->where('type_id', $this->typeId)
        ->when($this->search, function ($q) {
            $q->where('name', 'like', '%'.$this->search.'%');
        })
        ->get();

        return view('livewire.items-swiper');
    }
}
