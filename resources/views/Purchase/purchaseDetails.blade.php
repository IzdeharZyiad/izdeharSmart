@extends('welcome')

@section('title')
    تفاصيل العملية
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">

            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')" icon="fa-solid fa-cart-shopping">المشتريات</x-link-nav>
            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')"
                icon="fa-solid fa-user">{{ $purchase->seller->name . ' => ' . $purchase->id }}</x-link-nav>





        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')" icon="fa-solid fa-cart-shopping">المشتريات</x-link-nav>
            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')"
                icon="fa-solid fa-user">{{ $purchase->seller->name . ' => ' . $purchase->id }}</x-link-nav>



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
                    @if ($purchase->totalPrice == 0)
                        <a href="{{ route('purchases.addPurchaseMoney', ['purchaseId' => $purchase->id]) }}"
                            class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                                class="fa-solid fa-money-bill text-md  "></i>
                            <span class="hidden md:block mr-2">حساب السعر الكلي</span>
                        </a>

                        <a href="{{ route('purchases.purchaseDetails.addPurchaseDetails', ['purchaseId' => $purchase->id]) }}"
                            class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
                            <i class="fa-solid fa-building   text-sm "></i>
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
                        <th>الاسم</th>
                        <th>الحجم \ الوحدة </th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>السعر الكلي</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($purchaseDetails as $purchaseDetail)
                        @if ($purchaseDetail->type == 'product')
                            <tr class="border-b border-gray-200">
                                <td>{{ $purchaseDetail->productDetail->product->name }}</td>
                                <td>{{ $purchaseDetail->productDetail->size }}</td>
                                <td>{{ $purchaseDetail->quantity }}</td>
                                <td>{{ $purchaseDetail->price }}</td>
                                <td>{{ $purchaseDetail->subtotal }}</td>
                                <td>
                                    @if ($purchaseDetail->typeDisCount == null)
                                        <x-link class="text-green-900"
                                            href="{{ route('purchases.addPurchaseMoneyDis', ['purchaseDetailId' => $purchaseDetail->id]) }}"
                                            value="خصم" />
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr class="border-b border-gray-200">
                                <td>{{ $purchaseDetail->rawMaterial->name }}</td>
                                <td>{{ $purchaseDetail->rawMaterial->pruches_unit }}</td>
                                <td>{{ $purchaseDetail->quantity }}</td>
                                <td>{{ $purchaseDetail->price }}</td>
                                <td>{{ $purchaseDetail->subtotal }}</td>
                                <td>
                                    @if ($purchaseDetail->typeDisCount == null)
                                        <x-link class="text-green-900"
                                            href="{{ route('purchases.addPurchaseMoneyDis', ['purchaseDetailId' => $purchaseDetail->id]) }}"
                                            value="خصم" />
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>


            </table>



        </div>





    </div>
@endSection
