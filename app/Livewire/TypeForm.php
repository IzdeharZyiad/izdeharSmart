<?php

namespace App\Livewire;

use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class TypeForm extends Component
{
    public $name;
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';
    public $validateMessage = '';

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
            'name.required' => 'يجب تعبئة اسم القسم',
        ]);

        if ($validator->fails()) {
            $this->validateMessage = $validator->errors()->first();

            return;
        }

        $found = Type::where(['name' => $this->name, 'admin_id' => Auth::guard('admin')->user()->id])->get();
        if (blank($found)) {
            Type::create([
                'name' => $this->name,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $this->successMessage = 'تمت الاضافة بنجاح';
            $this->errorMessage = '';
            $this->validateMessage = '';

            return;
        } else {
            $this->errorMessage = 'تم تسجيل القسم سابقا';
            $this->successMessage = '';
            $this->validateMessage = '';

            return;
        }
    }

    public function render()
    {
        return view('livewire.type-form');
    }
}
