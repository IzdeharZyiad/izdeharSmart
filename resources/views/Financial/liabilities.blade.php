@extends('welcome')

@section('title')
    الالتزامات
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('financials')" :active="request()->routeIs('financials')" icon="fa-solid fa-money-bill">المالية</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('financials')" :active="request()->routeIs('financials')" icon="fa-solid fa-money-bill">المالية</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">الالتزامات</h1>
                </div>


            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto">

            <div class="flex flex-col md:grid grid-cols-3 mt-6 ">
                <div class="bg-white rounded-2xl shadow-lg border border-green-600 py-6 px-6 w-full">


                    <div class="text-center pb-3">
                        <h3 class="text-xl font-bold text-gray-800">
                            التزاماتي بالشيكات
                        </h3>

                        <p class="text-green-900 mt-4">{{ $sumCheque }}</p>

                    </div>








                </div>


                <div
                    class="bg-white rounded-2xl md-0  mt-4 md:mt-0 md:mr-4 shadow-lg border border-green-600 py-6 px-6 w-full">


                    <div class="text-center pb-3">
                        <h3 class="text-xl font-bold text-gray-800">
                            التزاماتي بالاقساط
                        </h3>

                        <p class="text-green-900 mt-4">{{ $sumInstallment }}</p>

                    </div>








                </div>




            </div>

        </div>





    </div>
@endSection
