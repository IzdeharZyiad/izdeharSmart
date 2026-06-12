<?php

namespace App\Livewire;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdateItem extends Component
{
    public $open = true;
    public $errorMessage = '';
    public $successMessage = '';
    public $validateMessage = '';
    public $itemId;
    public $itemName;
    public $item;

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->item = Item::find($this->itemId);
        $this->itemName = $this->item->name;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function updateName()
    {
        $validator = Validator::make([
            'itemName' => $this->itemName,
        ], [
            'itemName' => 'required',
        ], [
            'itemName.required' => 'يجب تعبئة اسم القسم',
        ]);

        if ($validator->fails()) {
            $this->validateMessage = $validator->errors()->first();

            return;
        }

        if ($this->item->name == $this->itemName) {
            $this->item->name = $this->itemName;
            $this->item->save();
            $this->successMessage = 'تم التعديل بنجاح';
            $this->errorMessage = '';
            $this->validateMessage = '';
        } else {
            $found = Item::where(['name' => $this->itemName, 'admin_id' => Auth::guard('admin')->user()->id])->get();
            if (blank($found)) {
                $this->item->name = $this->itemName;
                $this->item->save();

                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
                $this->validateMessage = '';
            } else {
                $this->errorMessage = 'تم تسجيل الفئة سابقا';
                $this->successMessage = '';
                $this->validateMessage = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.update-item');
    }
}
