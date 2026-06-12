@extends('welcome')

@section('title')
    السلف
@endSection
@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">

            <x-link-nav :href="route('users')" :active="request()->routeIs('users')">{{ $user->name }}</x-link-nav>



        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('users')" :active="request()->routeIs('users')">{{ $user->name }}</x-link-nav>


        </div>




    </div>
@endSection
@section('content')
    <div class="flex flex-col h-full ">
        <div class=" mt-4 h-[40px]  ">
            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">السلف</h1>
                </div>

                <div class="flex justify-end   ml-2 ">
                    <livewire:advance.advance-form :user_id="$user->id" :cycle_id="$cycle->id" />
                </div>


            </div>
        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-4 border-t border-gray-200  overflow-y-auto custom-scroll">



            <!-- cards -->
            <div class="flex flex-col md:grid grid-cols-3">

                <div class="border-b
                        md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-calender" text="الراتب" value="{{ $user->salary_amount }}" />
                </div>
                <div class="border-b md:border-l  border-gray-200">
                    <x-card-nav icon="fa-solid fa-calender" text="مجموع السلف هذا الشهر"
                        value="{{ $user->advance()->where('date', '>=', $cycle->start_date)->where('date', '<', $cycle->end_date)->sum('mount') }}" />
                </div>


                <div class="border-b
                        md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-calender" text="المتبقي"
                        value="{{ $user->salary_amount -
                            $user->advance()->where('date', '>=', $cycle->start_date)->where('date', '<', $cycle->end_date)->sum('mount') }}" />
                </div>






            </div>

            <div class="flex-1 flex flex-col overflow-y-auto custom-scroll ">

                <table id="myTable">
                    <thead>
                        <tr>

                            <th>التاريخ</th>
                            <th>اليوم</th>
                            <th>المبلغ</th>


                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($advances as $advance)
                            <tr class="border-b border-gray-200">
                                <td>{{ $advance->date }}</td>
                                <td>{{ $advance->dayName }}</td>
                                <td>{{ $advance->mount }}</td>
                                <td></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>

        </div>





    </div>
@endSection
