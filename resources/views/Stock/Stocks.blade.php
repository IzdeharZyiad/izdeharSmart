@extends('welcome')

@section('title')
    المخزون
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('stocks')" :active="request()->routeIs('stocks')" icon="fa-solid fa-boxes-stacked">المخزون</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('stocks')" :active="request()->routeIs('stocks')" icon="fa-solid fa-boxes-stacked">المخزون</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">المخزون</h1>
                </div>


            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto">


            <table id="myTable">
                <thead>
                    <tr>
                        <th>اسم المنتج</th>
                        <th>الكمية </th>

                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($products as $product)
                        <tr class="border-b border-gray-200">
                            <td>{{ $product->name }}</td>
                            <td>{{ optional($product->productDetail->first())->Quantity }}</td>
                            <td>
                                @if (optional($product->productDetail->first())->id != null)
                                    <x-link class="text-green-900"
                                        href="
                                   {{ route('stocks.StockMovments', ['productDetailId' => optional($product->productDetail->first())->id]) }}"
                                        value="حركات
                                    المنتج" />
                                @endif

                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>


        </div>







    </div>
@endSection
