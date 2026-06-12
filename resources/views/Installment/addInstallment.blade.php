@extends('welcome')

@section('title')
    اضافة تفاصيل القسط
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">

            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')" icon="fa-solid fa-cart-shopping">المشتريات</x-link-nav>
            <x-link-nav :href="route('purchases.instalment', [
                'purchaseId' => $purchase->id,
                'installmentId' => $purchase->installment?->id,
            ])" :active="request()->routeIs('purchases.instalment', [
                'purchaseId' => $purchase->id,
                'installmentId' => $purchase->installment?->id,
            ])"
                icon="fa-solid fa-money-bill">التقسيط</x-link-nav>:active="request()->routeIs('purchases.instalment',



        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')" icon="fa-solid fa-cart-shopping">المشتريات</x-link-nav>
            <x-link-nav :href="route('purchases.instalment', [
                'purchaseId' => $purchase->id,
                'installmentId' => $purchase->installment?->id,
            ])" :active="request()->routeIs('purchases.instalment', [
                'purchaseId' => $purchase->id,
                'installmentId' => $purchase->installment?->id,
            ])" icon="fa-solid fa-money-bill">التقسيط</x-link-nav>


        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="اضافة تفاصيل القسط " />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('purchases.instalment.storeInstalment') }}" method="POST">
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>



                    <input type="hidden" value="{{ $purchase->id }}" name="purchaseId">

                    <div class="hidden">
                        <livewire:date-day />
                    </div>

                    <livewire:installment :mount="$purchase->totalPrice" />


                    <div class="flex justify-center mt-5">
                        <x-primary-button>اضافة</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
