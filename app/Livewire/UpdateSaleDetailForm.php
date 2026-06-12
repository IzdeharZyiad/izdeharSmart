<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Product;
use App\Models\ProductDetail;
use Livewire\Component;

class UpdateSaleDetailForm extends Component
{
    public $filter = 'product';
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
    public $saleDetail;
    public $product_name;
    public $product_size;
    public $befor_price;
    public $befor_quantity;
    public $befor_totalPrice;
    public $befor_product_name;
    public $befor_product_size;

    public function mount($types, $saleDetail = null)
    {
        if ($saleDetail) {
            $this->types = $types;
            $this->items = collect();
            $this->saleDetail = $saleDetail;
            $this->product_id = $this->saleDetail->productDetail->product->id;
            $this->products = collect([
                $saleDetail->productDetail->product,
            ]);
            $this->productSize_id = $this->saleDetail->productDetail->id;
            $this->productSizes = collect([
                $saleDetail->productDetail,
            ]);

            $this->befor_product_name = $this->saleDetail->productDetail->product->name;
            $this->product_name = $this->saleDetail->productDetail->product->name;

            $this->befor_product_size = $this->saleDetail->productDetail->size;
            $this->product_size = $this->saleDetail->productDetail->size;
            $this->befor_price = $this->saleDetail->sale_price;
            $this->befor_quantity = $this->saleDetail->quantity;
            $this->befor_totalPrice = $this->saleDetail->subtotal;

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
        $this->product_name = $ProductDetail->product->name;
        $this->product_size = $ProductDetail->size;
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

    public function updatedFilter($value)
    {
        $this->filter = $value;
    }

    public function render()
    {
        return view('livewire.update-sale-detail-form');
    }
}
