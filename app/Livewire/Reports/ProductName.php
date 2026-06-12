<?php

namespace App\Livewire\Reports;

use App\Models\Item;
use App\Models\Product;
use Livewire\Component;

class ProductName extends Component
{
    public $types;
    public $type_id;
    public $items;
    public $item_id;
    public $products;

    public function mount($types)
    {
        $this->types = $types;
        $this->items = collect();
        $this->products = collect();
    }

    public function updateType_id($type_id)
    {
        $this->type_id = $type_id;
        $this->items = Item::where('type_id', $this->type_id)->get();
        $this->products = Product::whereHas('productDetail', function ($query) {
            $query->where('Quantity', '!=', 0);
        })
     ->whereIn('item_id', $this->items->pluck('id'))
    ->get();
        $this->dispatch('refreshTable');
    }

    public function exportPdf()
    {
        return redirect()->to(route('productNamePdf', ['type_id' => $this->type_id]));
    }

    public function render()
    {
        return view('livewire.reports.product-name');
    }
}
