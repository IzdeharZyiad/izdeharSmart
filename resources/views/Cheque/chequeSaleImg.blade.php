@extends('welcome')

@section('title')
    صورة الشيك
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>
            <x-link-nav :href="route('sales.cheque', ['saleId' => $cheque->chequeable_id])" :active="request()->routeIs('sales.cheque', ['saleId' => $cheque->chequeable_id])" icon="fa-solid fa-money-bill">الشيك</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('sales')" :active="request()->routeIs('sales')" icon="fa-solid fa-truck">المبيعات</x-link-nav>
            <x-link-nav :href="route('sales.cheque', ['saleId' => $cheque->chequeable_id])" :active="request()->routeIs('sales.cheque', ['saleId' => $cheque->chequeable_id])" icon="fa-solid fa-money-bill">الشيك</x-link-nav>

        </div>




    </div>
@endSection

@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="صورة الشيك " />
        </div>

        <div class="flex justify-center mt-2">
            <img class="border-2 border-gray-200 " src="{{ asset('storage/' . $cheque->chequeImg) }}" alt="cheque picture">
        </div>

    </div>
@endSection
