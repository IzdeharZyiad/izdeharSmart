@extends('welcome')

@section('title')
    المالية
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
                    <h1 class="text-green-900 text-sm font-medium">قائمة المالية</h1>
                </div>


            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto custom-scroll">

            <!-- cards -->
            <div class="flex flex-col md:grid grid-cols-2">
                <div class="border-b md:border-l  border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="نقدية المشتريات" value="{{ $SumTransication }}" />
                </div>
                <div class="border-b  md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="نقدية المبيعات " value="{{ $SumSaleCash }} " />
                </div>

                <div class="border-b  md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="الصندوق"
                        value="{{ $SumSaleCash - $SumTransication }} " />
                </div>

                <div class="border-b  md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-money-bill" text="صافي الربح" value="{{ $profit }} " />
                </div>


            </div>

            <div class="flex-1 flex flex-col overflow-y-auto custom-scroll ">
                <div class="flex flex-col md:grid grid-cols-2 mt-6 gap-2">
                    <div class="bg-white rounded-2xl shadow-lg border border-green-600 py-6 px-6 w-full">


                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-800">
                                المشتريات
                            </h3>
                            <p class="mt-3 text-green-900 font-medium">{{ $SumPurchase }}</p>

                        </div>



                        <!-- زر -->
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('financials.assets') }}"
                                class="w-full bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white text-center py-2 px-4 rounded-lg transition">
                                عرض
                            </a>
                        </div>

                    </div>

                    <div class="bg-white rounded-2xl mt-4  md:mt-0 shadow-lg border border-green-600 py-6 px-6 w-full">


                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-800">
                                الالتزامات
                            </h3>
                            <p class="mt-3 text-green-900 font-medium">{{ $sum }} </p>


                        </div>



                        <!-- زر -->
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('financials.liabilities') }}"
                                class="w-full bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white text-center py-2 px-4 rounded-lg transition">
                                عرض
                            </a>
                        </div>

                    </div>

                    <div class="bg-white rounded-2xl mt-4    md:mt-0 shadow-lg border border-green-600 py-6 px-6 w-full">


                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-800">
                                المبيعات
                            </h3>
                            <p class="mt-3 text-green-900 font-medium">{{ $SumSale }} </p>


                        </div>



                        <!-- زر -->
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('financials.revenues') }}"
                                class="w-full bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white text-center py-2 px-4 rounded-lg transition">
                                عرض
                            </a>
                        </div>

                    </div>

                    <div class="bg-white rounded-2xl mt-4    md:mt-0 shadow-lg border border-green-600 py-6 px-6 w-full">


                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-800">
                                دين الزبائن
                            </h3>
                            <p class="mt-3 text-green-900 font-medium">{{ $receivable }} </p>


                        </div>



                        <!-- زر -->
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('financials.receivable') }}"
                                class="w-full bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white text-center py-2 px-4 rounded-lg transition">
                                عرض
                            </a>
                        </div>

                    </div>

                    <div class="bg-white rounded-2xl mt-4    md:mt-0 shadow-lg border border-green-600 py-6 px-6 w-full">


                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-800">
                                المصروفات
                            </h3>
                            <p class="mt-3 text-green-900 font-medium">{{ $sumExpenses }}</p>


                        </div>



                        <!-- زر -->
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('financials.expenses') }}"
                                class="w-full bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white text-center py-2 px-4 rounded-lg transition">
                                عرض
                            </a>
                        </div>

                    </div>



                </div>

            </div>






        </div>





    </div>
@endSection
