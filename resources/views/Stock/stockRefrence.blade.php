@extends('welcome')
@section('title')
    سبب العملية
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-4 ">
            <x-link-nav :href="route('stocks')" :active="request()->routeIs('stocks')" icon="fa-solid fa-boxes-stacked">المخزون</x-link-nav>
            <x-link-nav :href="route('stocks.StockMovments', ['productDetailId' => $purchaseDetail->product_detail_id])" :active="request()->routeIs('stocks.StockMovments', [
                'productDetailId' => $purchaseDetail->product_detail_id,
            ])" icon="fa-solid fa-boxes-stacked">العملية</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-4">
            <x-link-nav :href="route('stocks')" :active="request()->routeIs('stocks')" icon="fa-solid fa-boxes-stacked">المخزون</x-link-nav>
            <x-link-nav :href="route('stocks.StockMovments', ['productDetailId' => $purchaseDetail->product_detail_id])" :active="request()->routeIs('stocks.StockMovments', [
                'productDetailId' => $purchaseDetail->product_detail_id,
            ])" icon="fa-solid fa-boxes-stacked">العملية</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">المخزون</h1>
                </div>


            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-8 border-t border-gray-200  overflow-y-auto">

            <div class="flex flex-col md:grid grid-cols-3">
                <div class="border-b md:border-l  border-gray-200">
                    <x-card-nav icon="fa-solid fa-hashtag" text="الكمية" value="{{ $purchaseDetail->quantity }}" />
                </div>
                <div class="border-b  md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-user" text="الاسم"
                        value="{{ $purchaseDetail->purchase->seller->name }} " />
                </div>

                <div class="border-b  md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-calendar" text="تاريخ العملية"
                        value=" {{ $purchaseDetail->purchase->dateDay }}" />
                </div>



            </div>


        </div>







    </div>
@endSection
