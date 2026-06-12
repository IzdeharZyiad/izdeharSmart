<div>

    <div class="flex gap-2 grid grid-cols-2 mt-4">

        <select
            class="  mr-4 px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
            name="type_id" wire:model="type_id" name="type_id" wire:change="updateType_id($event.target.value)">
            <option value="">الرجاء اختيار القسم</option>

            @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach

        </select>

        <button wire:click="exportPdf" class="px-4 py-2 ml-4 rounded-lg bg-gray-200 text-black">

            تنزيل
        </button>


    </div>

    <!-- مكان ال swipper اللي راح تتمدد-->
    <div class="flex-1 h-full flex flex-col  mt-4 border-t border-gray-200  overflow-y-auto custom-scroll">
        <div>
            <table id="productName">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المنتج</th>
                        <th>الكمية المتوفرة</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-b border-gray-200">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->productDetail->sum('Quantity') }}</td>
                        </tr>
                    @endforeach

                </tbody>

            </table>



        </div>

    </div>


</div>
