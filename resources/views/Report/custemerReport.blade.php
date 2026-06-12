@extends('welcome')
@section('title')
    ديون الزبائن
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">
            <x-link-nav :href="route('reportsCustemers')" :active="request()->routeIs('reportsCustemers')" icon="fa fa-soild fa-file">ديون الزبائن</x-link-nav>
        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">
            <x-link-nav :href="route('reportsCustemers')" :active="request()->routeIs('reportsCustemers')" icon="fa fa-soild fa-file">ديون الزبائن</x-link-nav>


        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full  ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">ديون الزبائن</h1>
                </div>
                <div class="flex justify-end space-x-4  ml-6 ">
                    <a href="{{ route('custemerReport') }}"
                        class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                            class="fa-solid fa-arrow-down text-md  "></i>
                        <span class="hidden md:block mr-2">تنزيل</span>
                    </a>

                </div>

            </div>

        </div>


        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-4 border-t border-gray-200  overflow-y-auto custom-scroll">

            <table id="myTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>اسم الزبون</th>
                        <th>مبلغ الديون</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($custemers as $custemer)
                        <tr class="border-b border-gray-200">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $custemer->name }}</td>
                            <td>{{ $custemer->balance }}</td>
                        </tr>
                    @endforeach



                </tbody>


            </table>



        </div>






    </div>
@endSection
