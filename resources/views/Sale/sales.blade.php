@extends('welcome')

@section('title')
    المبيعات
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
                    <h1 class="text-green-900 text-sm font-medium">قائمة المبيعات</h1>
                </div>
                <div class="flex justify-end space-x-4  ml-2 ">
                    <a
                        class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                            class="fa-solid fa-arrow-down text-md  "></i>
                        <span class="hidden md:block mr-2">تنزيل</span>
                    </a>

                    <a href="{{ route('sales.addsale') }}"
                        class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
                        <i class="fa-solid fa-truck   text-sm "></i>
                        <span class="hidden md:block mr-2">اضافة عملية بيع</span>
                    </a>



                </div>

            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto custom-scroll">


            <table id="myTable">
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>التاريخ</th>
                        <th>اليوم</th>
                        <th>اسم الزبون</th>
                        <th>طبيعة الدفع</th>
                        <th></th>


                    </tr>
                </thead>

                <tbody>

                    @foreach ($sales as $sale)
                        <tr
                            class="border-b border-gray-200
    {{ $sale->status == 'ملغية' ? 'bg-gray-100 text-gray-500' : '' }}">
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->dateDay }}</td>
                            <td>{{ $sale->dayName }}</td>
                            <td>{{ $sale->custemer->name ?? 'لا يوجد زبون' }}</td>
                            <td>{{ $sale->payment_type }}</td>


                            <td class="space-x-2">
                                @if ($sale->status != 'ملغية')
                                    <x-link class="text-green-900"
                                        href="{{ route('sales.updateSale', ['saleId' => $sale->id]) }}" value="تعديل" />

                                    <x-link class="text-green-900"
                                        href="{{ route('sales.saleDetails', ['saleId' => $sale->id]) }}" value="تفاصيل" />
                                @endif
                                @if ($sale->payment_type == 'تقسيط')
                                    @if ($sale->installment?->id != null)
                                        <x-link class="text-green-900"
                                            href="{{ route('sales.instalment', ['saleId' => $sale->id, 'installmentId' => $sale->installment->id]) }}"
                                            value="بيانات القسط" />
                                    @else
                                        <x-link class="text-green-900"
                                            href="{{ route('sales.instalment', ['saleId' => $sale->id]) }}"
                                            value="بيانات القسط" />
                                    @endif
                                @endif


                                @if ($sale->payment_type == 'شيك')
                                    <x-link class="text-green-900"
                                        href="{{ route('sales.cheque', ['saleId' => $sale->id]) }}" value="بيانات الشيك" />
                                @endif



                                <x-link class="text-green-900"
                                    href="{{ route('sales.transactionsSale', ['saleId' => $sale->id]) }}"
                                    value="المعاملات المالية" />


                            </td>


                        </tr>
                    @endforeach

                </tbody>


            </table>



        </div>







    </div>
@endSection
