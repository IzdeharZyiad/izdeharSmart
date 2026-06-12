<?php

namespace App\Livewire\Custemer;

use App\Models\Custemer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustemerSwiper extends Component
{
    public $search;
    public $open = false;
    public $custemerId;

    protected $listeners = ['closeModal'];

    public function updateId($custemerId)
    {
        $this->custemerId = $custemerId;
        $this->open = true;
    }

    public function updatedSearch()
    {
        $this->dispatch('refreshSwiper');
    }

    public function closeModal()
    {
        $this->open = false;
        $this->custemerId = null;
    }

    public function render()
    {
        if ($this->search == '') {
            $custemers = Custemer::query()
          ->where('admin_id', Auth::guard('admin')->user()->id)
            ->get();
        }
        $custemers = Custemer::query()
          ->where('admin_id', Auth::guard('admin')->user()->id)
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%');
            })
            ->get();

        return view('livewire.custemer.custemer-swiper', [
            'custemers' => $custemers,
        ]);
    }
}
