<?php

namespace App\Livewire;

use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TypesSwiper extends Component
{
    public $search = '';
    public $typeId = '';
    public $open = false;

    protected $listeners = ['closeModal'];

    public function render()
    {
        if ($this->search == '') {
            $types = Type::query()
          ->where('admin_id', Auth::guard('admin')->user()->id)
            ->get();
        }
        $types = Type::query()
          ->where('admin_id', Auth::guard('admin')->user()->id)
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%');
            })
            ->get();

        return view('livewire.types-swiper', [
            'types' => $types,
        ]);
    }

    public function updatedSearch()
    {
        $this->dispatch('refreshSwiper');
    }

    public function updateId($typeId)
    {
        $this->typeId = $typeId;
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
        $this->typeId = null;
    }
}
