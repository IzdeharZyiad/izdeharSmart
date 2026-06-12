@extends('welcome')

@section('title')
    المصروفات
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
                    <h1 class="text-green-900 text-sm font-medium">المصروفات</h1>
                </div>

                <div class="flex justify-end space-x-4  ml-2 ">
                    <livewire:financial.expenses-form />
                </div>
            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto">



            <table id="myTable">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>مبلغ </th>
                        <th>السبب</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($expenses as $expense)
                        <tr class="border-b border-gray-200">
                            <td>{{ $expense->dateDay }}</td>
                            <td>{{ $expense->mount }}</td>
                            <td>{{ $expense->type }}</td>
                        </tr>
                    @endforeach



                </tbody>
            </table>


        </div>







    </div>
@endSection
