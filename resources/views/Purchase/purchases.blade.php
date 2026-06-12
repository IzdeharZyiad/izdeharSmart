@extends('welcome')

@section('title')
    المشتريات
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')" icon="fa-solid fa-cart-shopping">المشتريات</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')" icon="fa-solid fa-cart-shopping">المشتريات</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">قائمة المشتريات</h1>
                </div>
                <div class="flex justify-end space-x-4  ml-2 ">
                    <a
                        class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                            class="fa-solid fa-arrow-down text-md  "></i>
                        <span class="hidden md:block mr-2">تنزيل</span>
                    </a>

                    <a href="{{ route('purchases.addPurchase') }}"
                        class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
                        <i class="fa-solid fa-cart-shopping   text-sm "></i>
                        <span class="hidden md:block mr-2">اضافة عملية شراء</span>
                    </a>



                </div>

            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto">


            <table id="myTable">
                <thead>
                    <tr>
                        <th>رقم العملية</th>
                        <th>اسم التاجر</th>
                        <th>التاريخ</th>
                        <th>اليوم</th>
                        <th>طريقة الدفع</th>


                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr class="border-b border-gray-200">
                            <td>{{ $purchase->id }}</td>
                            <td>{{ $purchase->seller->name }}</td>
                            <td>{{ $purchase->dateDay }}</td>
                            <td>{{ $purchase->dayName }}</td>
                            <td>{{ $purchase->payment_type }}</td>

                            <td class="space-x-2"><x-link class="text-green-900"
                                    href="{{ route('purchases.purchaseDetails', ['purchaseId' => $purchase->id]) }}"
                                    value="تفاصيل" />
                                @if ($purchase->payment_type == 'تقسيط')
                                    @if ($purchase->installment?->id != null)
                                        <x-link class="text-green-900"
                                            href="{{ route('purchases.instalment', ['purchaseId' => $purchase->id, 'installmentId' => $purchase->installment->id]) }}"
                                            value="بيانات القسط" />
                                    @else
                                        <x-link class="text-green-900"
                                            href="{{ route('purchases.instalment', ['purchaseId' => $purchase->id]) }}"
                                            value="بيانات القسط" />
                                    @endif
                                @endif

                                @if ($purchase->payment_type == 'شيك')
                                    <x-link class="text-green-900"
                                        href="{{ route('purchases.cheque', ['purchaseId' => $purchase->id]) }}"
                                        value="بيانات الشيك" />
                                @endif
                                <x-link
                                    href="{{ route('purchases.transactionsPurchase', ['purchaseId' => $purchase->id]) }}"
                                    class="text-green-900" value="المعاملات المالية" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>



        </div>







    </div>
@endSection
