<div class="flex-1 flex-col  gap-4">


    <div class="flex flex-col md:grid grid-cols-5 mt-4">
        <div class="grid grid-cols-[1fr_2fr] border-b md:border-l  border-gray-200">
            <div class="flex flex-col items-center justify-center"> <x-card-nav text="اسم المنتج  " value="" /></div>
            <div class="flex flex-col"> <x-card-nav text="  قبل " value="{{ $befor_product_name }}" />
                <x-card-nav text="  بعد " value="{{ $product_name }}" />
            </div>

        </div>
        <div class="grid grid-cols-[1fr_2fr] border-b md:border-l  border-gray-200">
            <div class="flex flex-col items-center justify-center"> <x-card-nav text="الحجم" value="" /></div>
            <div class="flex flex-col"> <x-card-nav text="  قبل " value="{{ $befor_product_size }}" />
                <x-card-nav class="text-green-900" text="  بعد " value="{{ $product_size }}" />
            </div>

        </div>
        <div class="grid grid-cols-[1fr_2fr] border-b md:border-l  border-gray-200">
            <div class="flex flex-col items-center justify-center"> <x-card-nav text="الكمية" value="" /></div>
            <div class="flex flex-col"> <x-card-nav text="  قبل " value="{{ $befor_quantity }}" />
                <x-card-nav text="  بعد " value="{{ $quantity }}" />
            </div>

        </div>
        <div class="grid grid-cols-[1fr_2fr] border-b md:border-l  border-gray-200">
            <div class="flex flex-col items-center justify-center"> <x-card-nav text="سعر القطعة " value="" />
            </div>
            <div class="flex flex-col"> <x-card-nav text="  قبل " value="{{ $befor_price }}" />
                <x-card-nav text="  بعد " value="{{ $price }}" />
            </div>

        </div>
        <div class="grid grid-cols-[1fr_2fr] border-b md:border-l  border-gray-200">
            <div class="flex flex-col items-center justify-center"> <x-card-nav text="السعر الكلي " value="" />
            </div>
            <div class="flex flex-col"> <x-card-nav text="  قبل " value="{{ $befor_totalPrice }}" />
                <x-card-nav text="  بعد " value="{{ $totalPrice }}" />
            </div>

        </div>
    </div>


    <div class="flex-1  md:grid grid-cols-[1fr_2fr] gap-2">
        <div class="flex flex-col mt-6  gap-6 border-r border-gray-200">
            <button type="button" wire:click="$set('filter', 'product')"
                class="{{ $filter == 'product' ? 'px-4 mr-4 py-2 rounded-lg  bg-green-900 text-white' : 'bg-gray-100 text-black px-4 py-2 mr-4 border border-green-900 rounded-lg bg-gray-100' }}">
                تعديل اسم المنتج وحجمه
            </button>

            <button type="button" wire:click="$set('filter', 'price')"
                class="{{ $filter == 'price' ? 'px-4 mr-4 py-2 rounded-lg bg-green-900 text-white' : 'bg-gray-100 text-black px-4 py-2 mr-4  border border-green-900 rounded-lg bg-gray-100' }}">
                تعديل الكمية والسعر
            </button>

        </div>
        <div class="mr-0  mt-6  items-center justify-center border-r border-gray-200">
            @if ($filter == 'product')
                <div class="flex flex-col gap-4 ml-4 mr-4 ">

                    <select
                        class="  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                        name="type_id" wire:model="type_id" name="type_id"
                        wire:change="updateType_id($event.target.value)">
                        <option value="">الرجاء اختيار القسم</option>

                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach

                    </select>



                    <select
                        class=" px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                        name="item_id" wire:model="item_id" name="item_id"
                        wire:change="updateItem_id($event.target.value)">
                        <option value="">الرجاء اختيار النوع</option>

                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach

                    </select>



                    <select
                        class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                        name="product_id" wire:model="product_id" wire:change="updateProduct_id($event.target.value)">
                        <option value="">الرجاء اختيار المنتج</option>

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach

                    </select>

                    <select
                        class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                        name="productSize_id" wire:model="productSize_id"
                        wire:change="updateProductSize_id($event.target.value)">
                        <option value="">الرجاء اختيار الحجم</option>

                        @foreach ($productSizes as $productSize)
                            <option value="{{ $productSize->id }}">{{ $productSize->size }}</option>
                        @endforeach

                    </select>


                </div>

            @endif

            @if ($filter == 'price')
                <div class="ml-4 mr-4 mt-2">
                    <x-floatingLabelInput id="price" wire:model="price" name="price" labelValue="سعر القطعة"
                        icon="fa-solid fa-money-bill" wire:change="updatePrice($event.target.value)" />

                    <x-floatingLabelInput id="quantity" name="quantity" labelValue="الكمية" wire:model="quantity"
                        wire:change="updateQuantity($event.target.value)" icon="fa-solid fa-hashtag" />

                    <x-floatingLabelInput id="totalPrice" name="totalPrice" labelValue="السعر الكلي"
                        value="{{ $totalPrice }}" icon="fa-solid fa-money-bill" readonly />
                </div>
            @endif
        </div>

    </div>

</div>
