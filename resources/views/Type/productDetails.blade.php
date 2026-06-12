@extends('welcome')

@section('title')
    احجام وكميات
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">

            <x-link-nav :href="route('types.items', ['typeId' => $item->type_id])" :active="request()->routeIs('types.items', ['typeId' => $item->id])" icon="fa-solid fa-building">{{ $item->name }}</x-link-nav>

            <x-link-nav :href="route('types.items.products', ['itemId' => $item->id])" :active="request()->routeIs('types.items.products', ['itemId' => $item->id])" icon="fa-solid fa-building">{{ $product->name }}</x-link-nav>




        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">

            <x-link-nav :href="route('types.items', ['typeId' => $item->type_id])" :active="request()->routeIs('types.items', ['typeId' => $item->id])" icon="fa-solid fa-building">{{ $item->name }}</x-link-nav>

            <x-link-nav :href="route('types.items.products', ['itemId' => $item->id])" :active="request()->routeIs('types.items.products', ['itemId' => $item->id])" icon="fa-solid fa-building">{{ $product->name }}</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">{{ $product->name }}</h1>
                </div>
                <div class="flex justify-end space-x-4  ml-2 ">
                    <a
                        class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                            class="fa-solid fa-arrow-down text-md  "></i>
                        <span class="hidden md:block mr-2">تنزيل</span>
                    </a>

                    <a href="{{ route('types.items.addProductDetails', ['itemId' => $product->item_id, 'productId' => $product->id]) }}"
                        class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
                        <i class="fa-solid fa-building   text-sm "></i>
                        <span class="hidden md:block mr-2">اضافة حجم وكمية</span>
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
                        <th>الحجم</th>
                        <th>الكمية</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($ProductDetails as $ProductDetail)
                        <tr class="border-b border-gray-200">
                            <td></td>
                            <td>{{ $ProductDetail->size }}</td>
                            <td>{{ $ProductDetail->Quantity }}</td>
                            <td class="mr-2 space-x-2">
                                <x-link class="text-green-900"
                                    href="{{ route('types.updateProductDetail', ['productDetailId' => $ProductDetail->id]) }}"
                                    value="تعديل" />

                                <x-link class="text-green-900"
                                    href="{{ route('types.recipes', ['productDetailId' => $ProductDetail->id]) }}"
                                    value="الوصفة" />
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>



        </div>





    </div>
@endSection
