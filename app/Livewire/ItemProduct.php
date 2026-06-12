<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Product;
use App\Models\ProductDetail;
use Livewire\Component;

class ItemProduct extends Component
{
    public $items;
    public $types;
    public $type_id;

    public $products;
    public $item_id;
    public $product_id;
    public $productSizes;
    public $productSize_id;
    public $type;
    public $rawMaterials;
    public $rawMaterial_id;

    public function mount($types, $rawMaterials)
    {
        $this->types = $types;
        $this->items = collect();
        $this->products = collect();
        $this->productSizes = collect();
        $this->item_id = null;
        $this->product_id = null;
        $this->type = null;
        $this->rawMaterials = $rawMaterials;
    }

    public function updateType($type)
    {
        $this->type = $type;
    }

    public function updateType_id($type_id)
    {
        $this->items = Item::where('type_id', $this->type_id)->get();
    }

    public function updateItem_id($item_id)
    {
        $this->products = Product::where('item_id', $this->item_id)->get();
    }

    public function updateProduct_id($product_id)
    {
        $this->productSizes = ProductDetail::where('product_id', $product_id)->get();
    }

    public function render()
    {
        return view('livewire.item-product');
    }
}
