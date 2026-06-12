@extends('welcome')

@section('title')
    الاعدادات
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('settings')" :active="request()->routeIs('settings')" icon="fa-solid fa-gear">الاعدادات</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('settings')" :active="request()->routeIs('settings')" icon="fa-solid fa-gear">الاعدادات</x-link-nav>

        </div>




    </div>
@endSection

@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="الاعدادات" />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl mt-10">
                <form action="{{ route('updateSettings') }}" method="POST">
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



                    <x-floatingLabelInput id="name" name="name" labelValue="الاسم"
                        value="{{ Auth::guard('admin')->user()->name }}" />

                    <x-floatingLabelInput id="phoneNumber" name="phoneNumber" labelValue="رقم الهاتف"
                        icon="fa-solid fa-phone" value="{{ Auth::guard('admin')->user()->phoneNumber }}" readonly />

                    <x-floatingLabelInput id="company_name" name="company_name" labelValue="اسم الشركة"
                        icon="fa-solid fa-building" value="{{ Auth::guard('admin')->user()->company_name }}" />

                    <div class="mt-5 flex justify-center mb-6 ">
                        <x-primary-button>حفظ</x-primary-button>







                </form>

            </div>




        </div>
    </div>
@endSection
