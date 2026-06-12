<?php

namespace App\Livewire\Sale;

use App\Models\Item;
use App\Models\Product;
use App\Models\ProductDetail;
use Livewire\Component;

class SaleForm extends Component
{
    public $items;
    public $types;
    public $products;
    public $item_id;
    public $type_id;
    public $product_id;
    public $productSizes;
    public $productSize_id;
    public $price;
    public $quantity;
    public $totalPrice;
    public $type;
    public $saleDetail;

    public function mount($types, $saleDetail = null)
    {
        if ($saleDetail) {
            $this->types = $types;
            $this->type_id = $saleDetail->productDetail->product->item->type;
            $this->items = collect([
                $saleDetail->productDetail->product->item,
            ]);
            $this->item_id = $this->saleDetail->productDetail->product->item->id;
            $this->saleDetail = $saleDetail;
            $this->product_id = $this->saleDetail->productDetail->product->id;
            $this->products = collect([
                $saleDetail->productDetail->product,
            ]);
            $this->productSize_id = $this->saleDetail->productDetail->id;
            $this->productSizes = collect([
                $saleDetail->productDetail,
            ]);

            $this->price = $this->saleDetail->sale_price;
            $this->quantity = $this->saleDetail->quantity;
            $this->totalPrice = $this->saleDetail->subtotal;
        } else {
            $this->types = $types;
            $this->items = collect();
            $this->products = collect();
            $this->productSizes = collect();
            $this->item_id = null;
            $this->product_id = null;
            $this->productSize_id = null;
            $this->price = null;
            $this->quantity = null;
            $this->totalPrice = null;
        }
    }

    public function updateType_id($type_id)
    {
        $this->items = Item::where('type_id', $this->type_id)->get();
    }

    public function updateType($type)
    {
        $this->type = $type;
    }

    public function updateItem_id($item_id)
    {
        $this->products = Product::where('item_id', $this->item_id)->get();
    }

    public function updateProduct_id($product_id)
    {
        $this->productSizes = ProductDetail::where('product_id', $product_id)->get();
    }

    public function updateProductSize_id($productSize_id)
    {
        $ProductDetail = ProductDetail::find($productSize_id);
        $this->price = $ProductDetail->sale_price;
        $this->totalPrice = $this->quantity * $this->price;
    }

    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->totalPrice = $this->quantity * $this->price;
    }

    public function render()
    {
        return view('livewire.sale.sale-form');
    }
}
