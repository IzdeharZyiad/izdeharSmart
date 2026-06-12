@extends('welcome')

@section('title')
    دفع دفعة تقسيط
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">

            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>
            <x-link-nav :href="route('sales.instalment', [
                'saleId' => $installmentDetail->installment->installmentable->id,
                'installmentId' => $installmentDetail->installment->id,
            ])" :active="request()->routeIs('sales.instalment', [
                'saleId' => $installmentDetail->installment->installmentable->id,
                'installmentId' => $installmentDetail->installment->id,
            ])" icon="fa-solid fa-money-bill">التقسيط</x-link-nav>



        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>
            <x-link-nav :href="route('sales.instalment', [
                'saleId' => $installmentDetail->installment->installmentable->id,
                'installmentId' => $installmentDetail->installment->id,
            ])" :active="request()->routeIs('sales.instalment', [
                'saleId' => $installmentDetail->installment->installmentable->id,
                'installmentId' => $installmentDetail->installment->id,
            ])" icon="fa-solid fa-money-bill">التقسيط</x-link-nav>


        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="اضافة دفعة القسط " />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('sales.storeInstallmentMount') }}" method="POST">
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>

                    <input type="hidden" value="{{ $installmentDetail->id }}" name="installmentDetailId">


                    <livewire:date-day />

                    <x-floatingLabelInput id="mount" name="mount" labelValue="الدفعة" icon="fa-solid fa-money-bill"
                        value="{{ $installmentDetail->amount }}" readonly />





                    <div class="flex justify-center mt-5">
                        <x-primary-button>اضافة</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
