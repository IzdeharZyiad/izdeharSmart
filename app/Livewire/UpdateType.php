<?php

namespace App\Livewire;

use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdateType extends Component
{
    public $open = true;
    public $errorMessage = '';
    public $successMessage = '';
    public $validateMessage = '';
    public $typeId;
    public $typeName;
    public $type;

    public function mount($typeId)
    {
        $this->typeId = $typeId;
        $this->type = Type::find($this->typeId);
        $this->typeName = $this->type->name;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function updateName()
    {
        $validator = Validator::make([
            'typeName' => $this->typeName,
        ], [
            'typeName' => 'required',
        ], [
            'typeName.required' => 'يجب تعبئة اسم القسم',
        ]);

        if ($validator->fails()) {
            $this->validateMessage = $validator->errors()->first();

            return;
        }

        if ($this->type->name == $this->typeName) {
            $this->type->name = $this->typeName;
            $this->type->save();
            $this->successMessage = 'تم التعديل بنجاح';
            $this->errorMessage = '';
            $this->validateMessage = '';
        } else {
            $found = Type::where(['name' => $this->typeName, 'admin_id' => Auth::guard('admin')->user()->id])->get();
            if (blank($found)) {
                $this->type->name = $this->typeName;
                $this->type->save();

                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
                $this->validateMessage = '';
            } else {
                $this->errorMessage = 'تم تسجيل القسم سابقا';
                $this->successMessage = '';
                $this->validateMessage = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.update-type');
    }
}
