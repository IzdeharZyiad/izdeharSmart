<div x-data="{ open: false }" class="relative">
    <button type="button" @click="open = !open" class="hover:text-green-700">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>

    <div x-show="open" x-cloak x-transition @click.outside="open = false"
        class="absolute left-4 mt-2 bg-white w-40 shadow-lg 
   border border-green-900 rounded-md  z-50">
        <div class="flex flex-col gap-4 pt-2 pb-3 ">
            <x-link_table text="عرض البيانات" icon="fa-solid fa-eye" />
            <x-link_table text="تعديل البيانات" icon="fa-solid fa-pen-to-square" />
            <x-link_table text="تتبع الراتب" icon="fa-sharp fa-solid fa-chart-simple" />
            <x-link_table text="تتبع الدوام" icon="fa-solid fa-calendar" class="border-b border-gray-200" />
            <x-delete-link text="حذف الموظف" />


        </div>
    </div>
</div>
