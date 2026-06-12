@extends('welcome')

@section('title')
    اضافة تفاصيل الشيك
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">

            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>
            <x-link-nav :href="route('sales.cheque', ['saleId' => $sale->id])" :active="request()->routeIs('sales.cheque', ['saleId' => $sale->id])" icon="fa-solid fa-money-bill">المعاملة</x-link-nav>



        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>

            <x-link-nav :href="route('sales.cheque', ['saleId' => $sale->id])" :active="request()->routeIs('sales.cheque', ['saleId' => $sale->id])" icon="fa-solid fa-money-bill">المعاملة</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="اضافة تفاصيل الشيك " />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('sales.cheque.storeCheque') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>

                    <input type="hidden" name="saleId" value="{{ $sale->id }}">

                    <x-floatingLabelInput type="date" id="dateToday" name="dateToday" labelValue="تاريخ الاستحقاق"
                        icon="fa-solid fa-calendar-day" value="{{ date('Y-m-d') }}" />



                    <x-floatingLabelInput id="finalPrice" name="finalPrice" labelValue="المبلغ الكلي"
                        icon="fa-solid fa-money-bill" value="{{ $sale->totalPrice }}" readonly />


                    <x-floatingLabelInput id="amount" name="amount" labelValue="مبلغ الشيك"
                        icon="fa-solid fa-money-bill" />

                    <x-floatingLabelInput id="cheque_remain" name="cheque_remain" labelValue="المبلغ المتبقي"
                        icon="fa-solid fa-money-bill" readonly
                        value="{{ $sale->totalPrice - $sale->cheques->sum('amount') }}" />

                    <x-floatingLabelInput id="cheque_number" name="cheque_number" labelValue="رقم  الشيك"
                        icon="fa-solid fa-hashtag" />

                    <x-floatingLabelInput id="bank_name" name="bank_name" labelValue="البنك"
                        icon="fa-solid fa-building-columns" />

                    <x-floatingLabelInput type="file" id="chequeImg" name="chequeImg" labelValue="صورة الشيك"
                        icon="fa-solid fa-file-image" />







                    <div class="flex justify-center mt-5">
                        <x-primary-button>اضافة</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
