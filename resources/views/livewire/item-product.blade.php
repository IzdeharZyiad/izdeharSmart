<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <div class=" mt-5 m-auto relative flex flex-col " dir="rtl">
        <select
            class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            name="type" wire:model="type" name="type" wire:change="updateType($event.target.value)">
            <option value="">الرجاء اختيار طبيعة الشراء</option>
            <option value="product">منتج</option>
            <option value="rawMeterial">مادة خام</option>
        </select>
    </div>

    @if ($type == 'product')

        <div class=" mt-5 m-auto relative flex flex-col " dir="rtl">
            <select
                class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                name="type_id" wire:model="type_id" name="type_id" wire:change="updateType_id($event.target.value)">
                <option value="">الرجاء اختيار القسم</option>

                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach

            </select>

        </div>


        <div class=" mt-5 m-auto relative flex flex-col " dir="rtl">
            <select
                class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                name="item_id" wire:model="item_id" name="item_id" wire:change="updateItem_id($event.target.value)">
                <option value="">الرجاء اختيار النوع</option>

                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach

            </select>

        </div>

        <div class="mt-5 m-auto relative flex flex-col " dir="rtl">
            <select
                class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                name="product_id" wire:model="product_id" wire:change="updateProduct_id($event.target.value)">
                <option value="">الرجاء اختيار المنتج</option>

                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach

            </select>

        </div>

        <div class="mt-5 m-auto relative flex flex-col " dir="rtl">
            <select
                class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                name="productSize_id" wire:model="productSize_id">
                <option value="">الرجاء اختيار الحجم</option>

                @foreach ($productSizes as $productSize)
                    <option value="{{ $productSize->id }}">{{ $productSize->size }}</option>
                @endforeach

            </select>

        </div>

    @endif

    @if ($type == 'rawMeterial')
        <div class=" mt-5 m-auto relative flex flex-col " dir="rtl">
            <select
                class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                name="rawMaterial_id" wire:model="rawMaterial_id" name="rawMaterial_id">
                <option value="">الرجاء اختيار الماده الخام</option>
                @foreach ($rawMaterials as $rawMaterial)
                    <option value="{{ $rawMaterial->id }}">{{ $rawMaterial->name }} - {{ $rawMaterial->pruches_unit }}
                    </option>
                @endforeach

            </select>

        </div>
    @endif

</div>
