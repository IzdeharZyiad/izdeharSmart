
    <div class="flex flex-col  ">
        <p class="mt-6 mr-2 text-gray-500">الرئيسية:</p>
        <div class="flex flex-col mr-6">
        <x-link-col icon="fa fa-home">الرئيسية</x-link-col>
        <x-link-col :href="route('users')" :active="request()->routeIs('users')">الموظفين</x-link-col>
        <x-link-col>التجار</x-link-col>
        <x-link-col>العملاء</x-link-col>
        <x-link-col icon="fa-solid fa-building">الاقسام</x-link-col>
        <x-link-col icon="fa-solid fa-cart-shopping">المشتريات</x-link-col>
        <x-link-col icon="fa-solid fa-truck">المبيعات</x-link-col>
        <x-link-col icon="fa-solid fa-boxes-stacked">المخزون</x-link-col>
        <x-link-col icon="fa-solid fa-money-bill">المالية</x-link-col>
        <x-link-col icon="fa fa-file">التقارير</x-link-col>
        </div>

    </div>

    <div class="flex flex-col gap-2">
        <p class="mt-6 mr-2 text-gray-500">اخرى:</p>
        <div class="flex flex-col mr-6">
        <x-link-col icon="fa-solid fa-gear">الاعدادات</x-link-col>
        <x-link-col>التواصل معنا</x-link-col>
</div>


    </div>



