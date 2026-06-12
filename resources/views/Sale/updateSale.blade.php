@extends('welcome')

@section('title')
    تعديل مبيعات
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
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="تعديل عملية بيع" />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('sales.editeSale') }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>

                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                    <livewire:date-day :sale="$sale" />

                    <x-floatingLabelInput id="payment_type" name="payment_type" labelValue="طريقه الدفع"
                        icon="fa-solid fa-money-bill" value="{{ $sale->payment_type }}" readonly />


                    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
                        <select
                            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                            name="custemer_id">
                            <option value="{{ $sale->custemer_id }}">{{ $sale->custemer->name }}</option>

                            @foreach ($custemers as $custemer)
                                <option value="{{ $custemer->id }}">{{ $custemer->name }}</option>
                            @endforeach

                        </select>
                    </div>







                    <div class="flex justify-center mt-5">
                        <x-primary-button>تعديل</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
