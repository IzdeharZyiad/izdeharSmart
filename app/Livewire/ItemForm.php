<?php

namespace App\Livewire;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ItemForm extends Component
{
    public $name;
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';
    public $validateMessage = '';
    public $typeId;

    public function mount($typeId)
    {
        $this->typeId = $typeId;
    }

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
        $validator = Validator::make([
            'name' => $this->name,
        ], [
            'name' => 'required',
        ], [
            'name.required' => 'يجب تعبئة اسم الفئة',
        ]);

        if ($validator->fails()) {
            $this->validateMessage = $validator->errors()->first();

            return;
        }

        $found = Item::where(['name' => $this->name, 'type_id' => $this->typeId])->get();
        if (blank($found)) {
            Item::create([
                'name' => $this->name,
                'type_id' => $this->typeId,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $this->successMessage = 'تمت الاضافة بنجاح';
            $this->errorMessage = '';
            $this->validateMessage = '';

            return;
        } else {
            $this->errorMessage = 'تم تسجيل الفئة سابقا';
            $this->successMessage = '';
            $this->validateMessage = '';

            return;
        }
    }

    public function render()
    {
        return view('livewire.item-form');
    }
}
