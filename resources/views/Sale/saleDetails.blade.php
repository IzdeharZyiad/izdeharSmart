@extends('welcome')

@section('title')
    تفاصيل العملية
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">

            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>





        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
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
                    <h1 class="text-green-900 text-sm font-medium"></h1>
                </div>
                <div class="flex justify-end space-x-4  ml-2 ">
                    <a href="{{ route('sales.custemerSale', ['saleId' => $sale->id]) }}"
                        class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                            class="fa-solid fa-arrow-down text-md  "></i>
                        <span class="hidden md:block mr-2">تنزيل</span>
                    </a>
                    @if ($sale->totalPrice == 0)
                        <a href="{{ route('sales.addSaleMoney', ['saleId' => $sale->id]) }}"
                            class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                                class="fa-solid fa-money-bill text-md  "></i>
                            <span class="hidden md:block mr-2">حساب السعر الكلي</span>
                        </a>


                        <a href="{{ route('sales.saleDetails.addSaleDetails', ['saleId' => $sale->id]) }}"
                            class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
                            <i class="fa-solid fa-truck   text-sm "></i>
                            <span class="hidden md:block mr-2">اضافة تفاصيل العملية </span>
                        </a>
                    @endif






                </div>

            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-4 border-t border-gray-200  overflow-y-auto custom-scroll">

            <table id="myTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>المنتج</th>
                        <th>الحجم</th>
                        <th>الكمية</th>
                        <th>الخصم</th>
                        <th>السعر الكلي</th>
                        <th>تكلفة الشراء</th>
                        <th>الربح</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($saleDetails as $saleDetail)
                        <tr class="border-b border-gray-200">
                            <td>{{ $saleDetail->id }}</td>
                            <td>{{ $saleDetail->productDetail->product->name }}</td>
                            <td>{{ $saleDetail->productDetail->size }}</td>
                            <td>{{ $saleDetail->quantity }}</td>
                            <td>{{ $saleDetail->disCount }}</td>
                            <td>{{ $saleDetail->subtotal }}</td>
                            <td>{{ $saleDetail->purchase_cost }}</td>
                            <td>{{ $saleDetail->profit }}</td>
                            <td class="space-x-2">
                                @if ($sale->totalPrice != 0)
                                    <x-link class="text-green-900"
                                        href="{{ route('sales.updateSaleDetail', ['saleDetailId' => $saleDetail->id]) }}"
                                        value="تعديل" />
                                @endif

                                @if ($sale->totalPrice != 0)
                                    <x-link class="text-red-600 hover:bg-red-700"
                                        href="{{ route('sales.cancelSaleDetail', ['saleDetailId' => $saleDetail->id]) }}"
                                        value="الغاء" />
                                @endif

                                @if ($saleDetail->typeDisCount == null)
                                    <x-link class="text-green-900"
                                        href="{{ route('sales.addSaleMoneyDis', ['saleDetail' => $saleDetail->id]) }}"
                                        value="الخصم" />
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>


            </table>



        </div>





    </div>
@endSection
