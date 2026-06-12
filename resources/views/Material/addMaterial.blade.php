@extends('welcome')

@section('title')
    اضافة ماده خام
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('rawMaterials')" :active="request()->routeIs('rawMaterials')" icon="fa-solid fa-seedling">المواد الخام</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('rawMaterials')" :active="request()->routeIs('rawMaterials')" icon="fa-solid fa-seedling">المواد الخام</x-link-nav>

        </div>
    </div>
@endSection

@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="اضافة ماده خام " />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('rawMaterials.storeMatrial') }}" method="POST">
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>


                    <x-floatingLabelInput id="name" name="name" labelValue="الاسم" icon="fa-solid fa-seedling" />

                    <x-floatingLabelInput id="quantity" name="quantity" labelValue="الكمية حسب وحدة الوصفات والبيع"
                        icon="fa-solid fa-hashtag" />
                    <x-floatingLabelInput id="lessQuantity" name="lessQuantity"
                        labelValue="اقل كمية مسموح بها حسب وحدة الوصفات والبيع" icon="fa-solid fa-hashtag" />



                    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
                        <select
                            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                            name="unit">
                            <option value="0">الرجاء اختيار وحدة الوصفات والبيع </option>
                            <option value="g">g</option>
                            <option value="ml">ml</option>
                        </select>
                    </div>


                    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
                        <select
                            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                            name="pruches_unit">
                            <option value="0">الرجاء اختيار وحدة الشراء </option>
                            <option value="Kg">Kg</option>
                            <option value="L">L</option>
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
