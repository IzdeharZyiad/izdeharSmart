<div>
    <x-floatingLabelInput id="finalPrice" name="finalPrice" labelValue="المبلغ المطلوب دفعه" icon="fa-solid fa-money-bill"
        readonly value="{{ $finalPrice }}" />
    <div class="hidden">
        <x-floatingLabelInput id="payment_type" name="payment_type" labelValue="طبيعه الدفع" icon="fa-solid fa-money-bill"
            readonly value="{{ $payment_type }}" />

    </div>
    <div class=" hidden md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            wire:model="type" name="type" wire:change="updateType($event.target.value)">
            <option value="0">كاش</option>
            <option value="1">شيك</option>
            <option value="2">تقسيط</option>
            <option value="3">مرن</option>

        </select>
    </div>

    @if ($payment_type == 'كاش')
        <x-floatingLabelInput id="amount" name="amount" labelValue="المبلغ" icon="fa-solid fa-money-bill" readonly
            value="{{ $amount }}" />
    @endif

    @if ($payment_type == 'شيك')
        <x-floatingLabelInput id="amount" name="amount" labelValue="المبلغ" icon="fa-solid fa-money-bill"
            wire:model="amount" wire:change="updateAmount($event.target.value)" />
    @endif

    @if ($type == 2)
        <x-floatingLabelInput id="amount" name="amount" labelValue="الدفعه الاولية" icon="fa-solid fa-money-bill"
            wire:model="amount" wire:change="updateAmount($event.target.value)" />
    @endif
    <x-floatingLabelInput id="remain" name="remain" labelValue="المبلغ المتبقي" icon="fa-solid fa-money-bill"
        value="{{ $remain }}" readonly />
    <div class="hidden">
        <livewire:date-day hidden />
    </div>





</div>
