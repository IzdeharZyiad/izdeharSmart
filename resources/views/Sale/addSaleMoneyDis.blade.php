@extends('welcome')

@section('title')
    اضافة تفاصيل العملية
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">


            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>
            <x-link-nav :href="route('sales.saleDetails', ['saleId' => $saleId])" :active="request()->routeIs('sales.saleDetails', ['saleId' => $saleId])" icon="fa-solid fa-truck">العملية</x-link-nav>




        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">

            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>

            <x-link-nav :href="route('sales.saleDetails', ['saleId' => $saleId])" :active="request()->routeIs('sales.saleDetails', ['saleId' => $saleId])" icon="fa-solid fa-truck">العملية</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="اضافة تفاصيل عملية البيع" />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('sales.storeSaleMoneyDis') }}" method="POST">
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>

                    <input type="hidden" name="saleDetailId" value="{{ $saleDetail->id }}">


                    <x-floatingLabelInput id="totalPrice" name="totalPrice" labelValue="السعر الكلي للبيع"
                        icon="fa-solid fa-money-bill" value="{{ $saleDetail->subtotal }}" readonly />

                    <livewire:sale.discount :totalPrice="$saleDetail->subtotal" />

                    <div class="flex justify-center mt-5">
                        <x-primary-button>اضافة</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
