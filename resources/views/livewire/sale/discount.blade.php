<div>




    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            wire:model="disCountType" name="disCountType" wire:change="updateDisCountType($event.target.value)">
            <option>الرجاء اختيار طبيعة الخصم</option>
            <option value="لا يوجد">لا يوجد</option>
            <option value="رقم"> رقم </option>

            <option value="نسبة مئوية"> نسبة مئوية </option>


        </select>
    </div>

    @if ($disCountType != 'لا يوجد')
        <x-floatingLabelInput id="disCount" name="disCount" labelValue="الخصم" icon="fa-solid fa-money-bill"
            wire:model="disCount" wire:change="updateDisCount($event.target.value)" />
    @endif
    <x-floatingLabelInput id="price" name="price" labelValue="السعر النهائي للدفع" icon="fa-solid fa-money-bill"
        value="{{ $price }}" />



</div>
