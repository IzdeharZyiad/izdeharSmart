@extends('welcome')

@section('title')
    تعديل موظف
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('users')" :active="request()->routeIs('users')">{{ $user->name }}</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('users')" :active="request()->routeIs('users')">{{ $user->name }}</x-link-nav>

        </div>
    </div>
@endSection

@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="تعديل موظف" />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('users.editUser') }}" method="POST">
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

                    <input type="hidden" name="userId" value="{{ $user->id }}" />

                    <x-floatingLabelInput id="name" name="name" labelValue="اسم الموظف"
                        value="{{ $user->name }}" />
                    <x-floatingLabelInput id="idNumber" name="idNumber" labelValue="رقم الهوية" icon="fa-solid fa-id-card"
                        value="{{ $user->idNumber }}" />
                    <x-floatingLabelInput id="phoneNumber" name="phoneNumber" labelValue="رقم الهاتف"
                        icon="fa-solid fa-phone" value="{{ $user->phoneNumber }}" />

                    <x-floatingLabelInput id="salary_amount" value="{{ $user->salary_amount }}" name="salary_amount"
                        labelValue="الراتب" icon="fa-solid fa-money-bill" />



                    <div class="flex mt-8  w-full justify-center pb-4">
                        <x-primary-button>تعديل</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
