<div>
    <div class=" mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            wire:model="type_id" name="type_id" wire:change="updateType_id($event.target.value)">
            <option value="">الرجاء اختيار القسم </option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach


        </select>

    </div>

    <div class=" mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            name="seller_id" wire:model="seller_id">
            <option value="">الرجاء اختيار اسم التاجر</option>

            @foreach ($sellers as $seller)
                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
            @endforeach

        </select>

    </div>

</div>
