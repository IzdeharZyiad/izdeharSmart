@extends('welcome')

@section('title')
    الموظفين
@endSection

@section('navbar-row')
    <x-navbar-row>
        <x-link-nav :href="route('users')" :active="request()->routeIs('users')">الموظفين</x-link-nav>
        <x-link-nav icon="fa-solid fa-calendar">الدوام اليومي</x-link-nav>


    </x-navbar-row>
@endSection

@section('content')
    <div class="flex flex-col">

        {{$slot}}

    </div>
@endSection
