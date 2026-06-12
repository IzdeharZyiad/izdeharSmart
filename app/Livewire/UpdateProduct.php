<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads; // لرفع الصور ضرورية

class UpdateProduct extends Component
{
    use WithFileUploads; // لرفع الصور ضرورية
    public $errorMessage = '';
    public $successMessage = '';
    public $name;
    public $productImg;
    public $productId;
    public $path;
    public $product;
    public $itemId;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->product = Product::find($this->productId);
        $this->name = $this->product->name;

        // $this->productImg = $this->product->productImg;
    }

    public function updateName()
    {
        // dd($this->productId);
        $this->validate([
            'name' => 'required',
            'productImg' => ['nullable', 'image'],
        ], [
            'name.required' => 'يجب تعبئة اسم المنتج',
            'productImg.image' => 'يجب ان يحتوي الحقل على صورة فقط',
        ]);

        if ($this->productImg) {
            $path = $this->productImg->store('productImg', 'public');
        } else {
            $path = $this->product->productImg;
        }

        if ($this->product->name == $this->name) {
            $this->product->productImg = $path;
            $this->product->save();
            $this->successMessage = 'تم التعديل بنجاح';
            $this->errorMessage = '';
        } else {
            $found = Product::where(['name' => $this->name, 'item_id' => $this->product->item_id])->get();
            if (blank($found)) {
                $this->product->name = $this->name;
                $this->product->productImg = $path;
                $this->product->save();
                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'تم تسجيل المنتج سابقا';
                $this->successMessage = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.update-product');
    }
}
