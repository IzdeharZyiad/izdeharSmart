@extends('welcome')

@section('title')
    المعاملات المالية
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
                    <h1 class="text-green-900 text-sm font-medium">المعاملات المالية</h1>
                </div>
                <div class="flex justify-end space-x-4  ml-2 ">



                    @if ($purchase->payment_type == 'كاش')
                        <a href="{{ route('purchases.transactionsPurchase.addTransactionsPurchas', ['purchaseId' => $purchase->id]) }}"
                            class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
                            <i class="fa-solid fa-money-bill   text-sm "></i>
                            <span class="hidden md:block mr-2">اضافة عملية </span>
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
                    <x-card-nav icon="fa-solid fa-money-bill" text="المبلغ الكلي" value="{{ $purchase->totalPrice }}" />
                </div>
                <div class="border-b  md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="المدفوع" value="{{ $transactions->sum('amount') }} " />
                </div>
                <div class="border-b md:border-l  border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="المتبقي"
                        value="{{ $purchase->totalPrice - $transactions->sum('amount') }}" />
                </div>

            </div>

            <div class="flex-1 flex flex-col ">

                <table id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>المبلغ</th>
                            <th>طريقة الدفع</th>

                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="border-b border-gray-200">
                                <td></td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->payment_methode }}</td>
                                <td class="space-x-2">
                                    @if ($transaction->payment_methode == 'شيك')
                                        <x-link class="text-green-900"
                                            href="{{ route('purchases.transactionsPurchase.cheque', ['transactionId' => $transaction->id]) }}"
                                            value="ادخال" />
                                    @endif


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>




        </div>





    </div>
@endSection
