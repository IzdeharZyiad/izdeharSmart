@extends('welcome')

@section('title')
    المواد الخام
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
    <div class="flex flex-col h-full ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">قائمة المواد الخام</h1>
                </div>
                <div class="flex justify-end space-x-4  ml-2 ">
                    <a
                        class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                            class="fa-solid fa-arrow-down text-md  "></i>
                        <span class="hidden md:block mr-2">تنزيل</span>
                    </a>

                    <a href="{{ route('rawMaterials.addMatrial') }}"
                        class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
                        <i class="fa-solid fa-seedling   text-sm "></i>
                        <span class="hidden md:block mr-2">اضافة ماده خام</span>
                    </a>



                </div>

            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto">


            <table id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>وحدة الوصفات والبيع</th>
                        <th>وحدة الشراء </th>
                        <th>الكمية</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($rawMaterials as $rawMaterial)
                        <tr class="border-b border-gray-200">
                            <td></td>
                            <td>{{ $rawMaterial->name }}</td>
                            <td>{{ $rawMaterial->unit }}</td>
                            <td>{{ $rawMaterial->pruches_unit }}</td>
                            <td>{{ $rawMaterial->quantity }}</td>
                            <td></td>
                        </tr>
                    @endforeach


                </tbody>


            </table>



        </div>







    </div>
@endSection
