<div>
    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            wire:model="sizeType_id" name="sizeType_id" wire:change="updateSizeType_id($event.target.value)">
            <option value="">الرجاء اختيار نوع الحجم</option>
            @foreach ($sizeTypes as $id => $name)
                <option value="{{ $id }}">
                    {{ $name }}
                </option>
            @endforeach
        </select>

    </div>

    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
        <select name="size"
            class="w-full  px-2.5 pb-2.5 pt-4 border  border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0" ">


               @foreach ($sizes as $id=> $name)
            <option value="{{ $name }}">{{ $name }}</option>
            @endforeach

        </select>

    </div>


</div>
