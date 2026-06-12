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
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="اضافة عملية شراء" />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('purchases.storePurchase') }}" method="POST">
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>

                    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
                        <select
                            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                            name="seller_id">
                            <option value="0">الرجاء اختيار اسم التاجر </option>
                            @foreach ($sellers as $seller)
                                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                            @endforeach


                        </select>
                    </div>

                    <livewire:date-day />

                    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
                        <select
                            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                            name="payment_type">
                            <option value="">الرجاء اختيار طريقه الدفع</option>
                            <option value="0">كاش</option>
                            <option value="1">شيك</option>
                            <option value="2">تقسيط</option>
                            <option value="4">مختلط</option>

                        </select>
                    </div>


                    <div class="flex justify-center mt-5">
                        <x-primary-button>اضافة</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
