<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads; // لرفع الصور ضرورية

class ProductForm extends Component
{
    use WithFileUploads; // لرفع الصور ضرورية
    public $name;
    public $productImg;
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';
    public $itemId;

    public function openModal()
    {
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'productImg' => ['image', 'nullable'],
        ], [
            'name.required' => 'يجب تعبئة اسم المنتج',
            'productImg.image' => 'يجب ان يحتوي الحقل على صورة فقط',
        ]);

        $found = Product::where(['name' => $this->name, 'item_id' => $this->itemId])->get();
        $path = null;

        if (blank($found)) {
            if ($this->productImg) {
                $path = $this->productImg->store('productImg', 'public');
            }

            $product = Product::create([
                'name' => $this->name,
                'productImg' => $path,
                'item_id' => $this->itemId,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);

            $this->successMessage = 'تمت الاضافة بنجاح';
            $this->errorMessage = '';
        } else {
            $this->errorMessage = 'تم تسجيل المنتج سابقا';
            $this->successMessage = '';
        }
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}
