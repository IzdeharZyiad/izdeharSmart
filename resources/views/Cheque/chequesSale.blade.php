@extends('welcome')

@section('title')
    تفاصيل الشيك
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>

        </div>




    </div>
@endSection

@section('content')
    <div class="flex flex-col h-full ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">تفاصيل الشيك</h1>
                </div>
                <div class="flex justify-end space-x-4  ml-2 ">
                    <a
                        class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                            class="fa-solid fa-arrow-down text-md  "></i>
                        <span class="hidden md:block mr-2">تنزيل</span>
                    </a>


                    @if ($sale->cheques->sum('amount') != $sale->totalPrice)
                        <a href="{{ route('sales.cheque.addCheque', ['saleId' => $sale->id]) }}"
                            class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
                            <i class="fa-solid fa-money-bill   text-sm "></i>
                            <span class="hidden md:block mr-2">اضافة شيك </span>
                        </a>
                    @endif
                </div>

            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto">

            <!-- cards -->
            <div class="flex flex-col md:grid grid-cols-3">
                <div class="border-b md:border-l  border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="مبلغ الشيكات" value="{{ $sale->totalPrice }}  " />
                </div>
                <div class="border-b  md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="المبلغ المدفوع"
                        value="{{ $sale->transactions->sum('amount') }}  " />
                </div>

                <div class="border-b  md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="المتبقي"
                        value="{{ $sale->totalPrice - $sale->transactions->sum('amount') }}   " />
                </div>


            </div>

            <div class="flex-1 flex flex-col overflow-y-auto custom-scroll ">

                <table id="myTable">
                    <thead>
                        <tr>
                            <th>رقم الشيك</th>
                            <th>المبلغ</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>الحالة</th>

                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($cheques as $cheque)
                            <tr class="border-b border-gray-200">
                                <td>{{ $cheque->cheque_number }}</td>
                                <td>{{ $cheque->amount }}</td>
                                <td>{{ $cheque->due_date }}</td>
                                <td>{{ $cheque->status }}</td>
                                <td class="space-x-2">
                                    <x-link class="text-green-900"
                                        href="
                                    {{ route('sales.addChequeMount', ['chequeId' => $cheque->id]) }}"
                                        value="دفع" />

                                    <x-link class="text-green-900"
                                        href="
                                    {{ route('sales.chequeImg', ['chequeId' => $cheque->id]) }}"
                                        value="صورة الشيك" />
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>




        </div>





    </div>
@endSection
