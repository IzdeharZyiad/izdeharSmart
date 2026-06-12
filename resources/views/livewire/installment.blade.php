<div>
    <x-floatingLabelInput id="amount" name="amount" labelValue="مبلغ الشراء" icon="fa-solid fa-money-bill"
        wire:model="amount" value="{{ $amount }}" readonly />

    <x-floatingLabelInput id="firstPay" name="firstPay" labelValue="الدفعه الاولية" icon="fa-solid fa-money-bill"
        wire:model="firstPay" wire:change="updateFirstPay($event.target.value)" />

    <x-floatingLabelInput id="finalMount" name="finalMount" labelValue="المبلغ لنهائي " icon="fa-solid fa-money-bill"
        readonly value="{{ $finalMount }}" />

    <x-floatingLabelInput id="installmentsCount" name="installmentsCount" labelValue="عدد  الاقساط"
        icon="fa-solid fa-money-bill" wire:model="installmentsCount"
        wire:change="updateInstallmentsCount($event.target.value)" />

    <x-floatingLabelInput id="installmentAmount" name="installmentAmount" labelValue="مبلغ كل قسط"
        icon="fa-solid fa-money-bill" readonly value="{{ $installmentAmount }}" />



    <x-floatingLabelInput id="intervalDays" name="intervalDays" labelValue="الفترة بين  كل قسط"
        icon="fa-solid fa-calendar-day" />

    <div class="mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            name="intervalType">
            <option value="">الرجاء اختيار نوع المده</option>

            <option value="day">يوم</option>

            <option value="week">اسبوع</option>

            <option value="month">شهر</option>


        </select>

    </div>



    <x-floatingLabelInput type="date" id="startDate" name="startDate" labelValue="بداية الدفع"
        icon="fa-solid fa-calendar-day" value="{{ $startDate }}" />



</div>
