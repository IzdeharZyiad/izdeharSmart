@extends('welcome')

@section('title')
    التقارير
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">
            <x-link-nav :href="route('reports')" :active="request()->routeIs('reports')" icon="fa fa-soild fa-file">التقارير</x-link-nav>
        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('reports')" :active="request()->routeIs('reports')" icon="fa fa-soild fa-file">التقارير</x-link-nav>


        </div>




    </div>
@endSection

@section('content')
    <div class="flex flex-col md:grid grid-cols-2 mr-2 ml-2 mt-6 gap-2">
        <div class="bg-white rounded-2xl  shadow-lg border border-green-600 py-6 px-6 ">


            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800">
                    كشف حساب للزبائن
                </h3>

            </div>

            <!-- زر -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('accountStatementCustemer') }}"
                    class="w-full bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white text-center py-2 px-4 rounded-lg transition">
                    عرض
                </a>
            </div>

        </div>

        <div class="bg-white rounded-2xl   shadow-lg border border-green-600 py-6 px-6 ">


            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800">
                    المنتجات المتوفرة
                </h3>

            </div>

            <!-- زر -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('productName') }}"
                    class="w-full bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white text-center py-2 px-4 rounded-lg transition">
                    عرض
                </a>
            </div>

        </div>

        <div class="bg-white rounded-2xl   shadow-lg border border-green-600 py-6 px-6">


            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-800">
                    ديون الزبائن
                </h3>

            </div>

            <!-- زر -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('reportsCustemers') }}"
                    class="w-full bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white text-center py-2 px-4 rounded-lg transition">
                    عرض
                </a>
            </div>

        </div>







    </div>
@endSection
