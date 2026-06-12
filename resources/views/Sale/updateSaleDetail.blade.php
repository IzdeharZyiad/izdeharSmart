@extends('welcome')

@section('title')
    تعديل تفاصيل العملية
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">


            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>
            <x-link-nav :href="route('sales.saleDetails', ['saleId' => $saleDetail->sale_id])" :active="request()->routeIs('sales.saleDetails', ['saleId' => $saleDetail->sale_id])" icon="fa-solid fa-truck">العملية</x-link-nav>




        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">


            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>
            <x-link-nav :href="route('sales.saleDetails', ['saleId' => $saleDetail->sale_id])" :active="request()->routeIs('sales.saleDetails', ['saleId' => $saleDetail->sale_id])" icon="fa-solid fa-truck">العملية</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 pb-2 border-b border-gray-200">
            <x-heading value="تعديل تفاصيل عملية البيع" />
        </div>

        <div class="flex-1 h-full flex flex-col  overflow-y-auto custom-scroll ">




            <form action="{{ route('sales.saleDetails.storeSaleDetails') }}" method="POST">
                @csrf
                <div>
                    @if (session('error'))
                        <x-alert-danger value="{{ session('error') }}" />
                    @endif

                    @if (session('success'))
                        <x-alert-sucess value="{{ session('success') }}" />
                    @endif
                </div>

                <livewire:update-sale-detail-form :types="$types" :saleDetail="$saleDetail" />

                <div class="flex justify-center mt-5 md:w-1/3 md:-mt-10 ">

                    <x-primary-button>حفظ التعديلات</x-primary-button>


                </div>

            </form>

        </div>







    </div>
@endSection
