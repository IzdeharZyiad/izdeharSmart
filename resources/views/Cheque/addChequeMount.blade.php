@extends('welcome')

@section('title')
    دفع دفعة الشيك
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">

            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')" icon="fa-solid fa-cart-shopping">المشتريات</x-link-nav>

            <x-link-nav :href="route('purchases.cheque', ['purchaseId' => $cheque->chequeable->id])" :active="request()->routeIs('purchases.cheque', ['purchaseId' => $cheque->chequeable->id])" icon="fa-solid fa-money-bill">المعاملة</x-link-nav>



        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('purchases')" :active="request()->routeIs('purchases')" icon="fa-solid fa-cart-shopping">المشتريات</x-link-nav>
            <x-link-nav :href="route('purchases.cheque', ['purchaseId' => $cheque->chequeable->id])" :active="request()->routeIs('purchases.cheque', ['purchaseId' => $cheque->chequeable->id])" icon="fa-solid fa-money-bill">المعاملة</x-link-nav>



        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="اضافة دفعة الشيك " />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('purchases.storeChequeMount') }}" method="POST">
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>

                    <input type="hidden" value="{{ $cheque->id }}" name="chequeId">


                    <livewire:date-day />

                    <x-floatingLabelInput id="mount" name="mount" labelValue="الدفعة" icon="fa-solid fa-money-bill"
                        value="{{ $cheque->amount }}" readonly />





                    <div class="flex justify-center mt-5">
                        <x-primary-button>اضافة</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
