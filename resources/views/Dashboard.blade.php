@extends('welcome')
@section('title')
    الصفحة الرئيسية
@endSection

@section('navbar-row')
    <div class="flex-1 flex flex-col h-full justify-center md:hidden">
        <x-dashboards-nav />
    </div>
    <!-- center in md and above -->
    <div class="hidden flex-1 flex items-center h-full  md:inline-flex ">
        <div class="flex mr-2 space-x-6">
            <x-row-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="fa fa-soild fa-home" text="الرئيسية" />
            <x-row-link :href="route('purchaseDashboard')" :active="request()->routeIs('purchaseDashboard')" icon="fa fa-soild fa-cart-shopping" text=" المشتريات" />
            <x-row-link :href="route('saleDashboard')" :active="request()->routeIs('saleDashboard')" icon="fa fa-soild fa-truck" text=" المبيعات" />
            <x-row-link :href="route('stockDashboard')" :active="request()->routeIs('stockDashboard')" icon="fa fa-soild fa-boxes-stacked" text=" المخزون" />
        </div>



    </div>
@endSection


@section('content')
    @yield('report')
@endSection
