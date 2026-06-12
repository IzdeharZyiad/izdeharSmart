<div class="flex flex-col h-full  ">

    <div class=" mt-4 h-[40px]   ">

        <div class="flex  gap-2">


            <select
                class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                name=custemer_id" wire:model=custemer_id" name=custemer_id"
                wire:change="updatCustemer_id($event.target.value)">
                <option value="">الرجاء اختيار الزبون</option>

                @foreach ($custmers as $custmer)
                    <option value="{{ $custmer->id }}">{{ $custmer->name }}</option>
                @endforeach

            </select>


            <button wire:click="$set('filter', 'all')"
                class="{{ $filter == 'all' ? 'px-4 py-2 mr-4 rounded-lg bg-green-900 text-white' : 'bg-gray-100 text-black px-4 py-2 mr-4 rounded-lg bg-gray-100' }}">
                الكل
            </button>
            <button wire:click="exportPdf" class="px-4 py-2 ml-4 rounded-lg bg-gray-200 text-black">

                تنزيل
            </button>

        </div>

    </div>

    <!-- مكان ال swipper اللي راح تتمدد-->
    <div class="flex-1 h-full flex flex-col  mt-4 border-t border-gray-200  overflow-y-auto custom-scroll">

        <!-- cards -->
        <div class="flex flex-col md:grid grid-cols-3 md:h-25">
            <div class="border-b md:border-l  border-gray-200">
                <x-card-nav icon="fa-solid fa-money-bill" text="مجموع الديون" value="{{ $sumSale }}" />
            </div>
            <div class="border-b  md:border-l border-gray-200">
                <x-card-nav icon="fa-solid fa-money-bill" text="المبلغ المدفوع" value="{{ $sumTransiction }}" />
            </div>
            <div class="border-b md:border-l  border-gray-200">
                <x-card-nav icon="fa-solid fa-money-bill" text="المبلغ المتبقي" value="{{ $reset }}" />
            </div>

        </div>
        <div>
            <table id="account_id">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>النوع</th>
                        <th>البيان</th>
                        <th>الدين</th>
                        <th>المبلغ المدفوع</th>
                        <th>المتبقي</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($statements as $statement)
                        <tr class="border-b border-gray-200">
                            <td>{{ $statement['date'] }}</td>
                            <td>{{ $statement['type'] }}</td>
                            <td>{{ $statement['info'] }}</td>
                            <td>{{ $statement['debit'] }}</td>
                            <td>{{ $statement['credit'] }}</td>
                            <td>{{ $statement['balance'] }}</td>
                        </tr>
                    @endforeach

                </tbody>

            </table>



        </div>
    </div>



</div>
