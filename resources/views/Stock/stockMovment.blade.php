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
                        <th>العملية </th>
                        <th>الكمية </th>
                        <th>الكمية قبل</th>
                        <th>الكمية بعد</th>


                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($stocks as $stock)
                        <tr class="border-b border-gray-200">
                            <td>{{ $stock->productDetail->product->name }}</td>
                            <td>{{ $stock->type }}</td>
                            <td>{{ $stock->quantity }}</td>
                            <td>{{ $stock->before_quantity }}</td>
                            <td>{{ $stock->after_quantity }}</td>

                            <td>
                                @if ($stock->purchase_detail_id != null)
                                    <x-link class="text-green-900"
                                        href="{{ route('stocks.stockRefrence', ['purchaseDetailId' => $stock->purchase_detail_id]) }}"
                                        value="سبب العملية" />
                                @endif
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>


        </div>







    </div>
@endSection
