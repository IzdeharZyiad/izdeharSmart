@extends('welcome')

@section('title')
    الدوام اليومي
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
                    <h1 class="text-green-900 text-sm font-medium">الدوام اليومي</h1>
                </div>


            </div>
        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-4 border-t border-gray-200  overflow-y-auto custom-scroll">



            <!-- cards -->
            <div class="flex flex-col md:grid grid-cols-2">
                <div class="border-b md:border-l  border-gray-200">
                    <x-card-nav icon="fa-solid fa-calender" text="عدد ايام الحضور"
                        value="{{ $user->attendance()->where('date', '>=', $cycle->start_date)->where('date', '<', $cycle->end_date)->where('status', 'حضور')->count() }}" />
                </div>
                <div class="border-b
                        md:border-l border-gray-200">
                    <x-card-nav icon="fa-solid fa-calender" text="عدد ايام الغياب"
                        value="{{ $user->attendance()->where('date', '>=', $cycle->start_date)->where('date', '<', $cycle->end_date)->where('status', 'غياب')->count() }}" />
                </div>






            </div>

            <div class="flex-1 flex flex-col overflow-y-auto custom-scroll ">
                <div id="calendar"></div>

                <livewire:Attendance.attendace-form :user_id="$user->id" :cycle_id="$cycle->id" />

            </div>



        </div>





    </div>
@endSection

@section('script')
    <script>
        window.calendarEvents = @json($events);
    </script>
@endSection
