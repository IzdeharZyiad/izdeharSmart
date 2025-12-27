<?php

use function Livewire\Volt\{state};
use function Livewire\Volt\{layout};
use function Livewire\Volt\{rules};
use app\Models\User;

use App\Livewire\Traits\AddUserValidation;

layout('components.layouts.users');

state(['name', 'idNumber', 'phoneNumber', 'joinDate', 'salary_type', 'salary_amount', 'department', 'balance']);
$AddUser=function(){
 //  $this->validate(AddUserValidation::rules() , AddUserValidation::message());
   $this->dispatch('name' , 'izdehar');
}

?>

<div>



    <x-title-card title="اضافة موظف" />

    <x-main-card class="h-[500px]">
           <form wire:submit="AddUser">

        <div class="grid grid-cols-2">

         

            <!-- first -->
            <div class="border-l-2  border-gray-200 mt-4">
                <x-floatingLabelInput id="name" name="name" labelValue="الاسم" />
                <x-floatingLabelInput id="idNumber" name="idNumber" labelValue="رقم الهوية" icon="fa-solid fa-phone" />
                <x-floatingLabelInput id="phoneNumber" name="phoneNumber" labelValue="رقم الهاتف"
                    icon="fa-solid fa-address-card" />

                <x-floatingLabelInput type="date" value="{{ now()->timezone('Asia/Gaza')->toDateString() }}"
                    id="joinDate" name="joinDate" labelValue="تاريخ الانضمام" icon="fa-solid fa-calendar" />

            </div>

            <!-- second -->
            <div class="mt-4">
                <div class="max-w-sm md:max-w-md mt-5 m-auto relative flex flex-col " dir="rtl">


                    <x-selectDropDown holder="اختر طريقه الراتب" name="salary_type">
                        <x-selectDrop-link value="ساعة">ساعة</x-selectDrop-link>
                        <x-selectDrop-link value="يومي">يومي</x-selectDrop-link>
                        <x-selectDrop-link value="شهري">شهري</x-selectDrop-link>


                    </x-selectDropDown>

                </div>

                <x-floatingLabelInput id="salary_amount" name="salary_amount" labelValue="الراتب/سعر الساعة"
                    icon="fa-solid fa-money-bill" />




                <div class="max-w-sm md:max-w-md mt-5 m-auto relative flex flex-col " dir="rtl">


                    <x-selectDropDown holder="اختر  القسم الذي يعمل فيه" name="department">

                    </x-selectDropDown>
                </div>


                <x-floatingLabelInput id="balance" name="balance" labelValue="رصيد له / او عليه"
                    icon="fa-solid fa-money-bill" />


            </div>











        </div>

        <div class="mt-14 flex  w-full justify-center ">
            <x-primary-button>تأكيد الاضافة</x-primary-button>
        </div>

        </form>

    </x-main-card>







</div>
