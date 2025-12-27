@extends('welcome')
@section('title')
    الصفحة الرئيسية
@endSection

@section('navbar-row')
    <x-navbar-row>
        <x-link-nav  icon="fa-solid fa-cart-shopping">لوحة المشتريات</x-link-nav>
        <x-link-nav icon="fa-solid fa-truck">لوحة المبيعات</x-link-nav>
        <x-link-nav icon="fa-solid fa-boxes-stacked">لوحة المخزون</x-link-nav>
        <x-link-nav icon="fa-solid fa-building">لوحة المنتجات</x-link-nav>
        <x-link-nav>لوحة الموظفين</x-link-nav>
        <x-link-nav icon="fa-solid fa-calendar">التقويم</x-link-nav>

    </x-navbar-row>
@endSection


@section('content')

@endSection