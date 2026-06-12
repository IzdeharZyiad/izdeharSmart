<div>
    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            name="payment_type" wire:model="payment_type" wire:change="updatepaymentType($event.target.value)">
            <option value="">الرجاء اختيار طريقه الدفع
            </option>
            <option value="0">كاش</option>
            <option value="1">شيك</option>
            <option value="2">تقسيط</option>
            <option value="3">مرن</option>
        </select>
    </div>


    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            name="custemer_id">
            <option value="0">الرجاء اختيار اسم الزبون</option>

            @foreach ($custemers as $custemer)
                <option value="{{ $custemer->id }}">{{ $custemer->name }}</option>
            @endforeach

        </select>
    </div>

</div>
