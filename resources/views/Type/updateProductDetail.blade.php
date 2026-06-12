@extends('welcome')

@section('title')
    تعديل
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">




        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">


        </div>




    </div>
@endSection

@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="تعديل" />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('types.EditeProductDetail') }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>

                    <input type="hidden" name="productDetailId" value="{{ $productDetail->id }}">


                    <div class="hidden">
                        <x-floatingLabelInput id="Quantity" name="Quantity" labelValue="الكمية" icon="fa-solid fa-hashtag"
                            value="{{ $productDetail->Quantity }}" readonly />
                    </div>

                    <x-floatingLabelInput id="sale_price" name="sale_price" labelValue="سعر البيع للمنتج"
                        icon="fa-solid fa-money-bill" value="{{ $productDetail->sale_price }}" />

                    <x-floatingLabelInput id="lessQuantity" name="lessQuantity" labelValue="أقل كمية مسموح بها"
                        icon="fa-solid fa-hashtag" value="{{ $productDetail->lessQuantity }}" />

                    <div class="flex justify-center mt-5">
                        <x-primary-button>تعديل</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
