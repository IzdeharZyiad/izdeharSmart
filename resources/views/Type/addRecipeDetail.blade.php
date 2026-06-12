@extends('welcome')

@section('title')
    اضافة مادة خام للوصفة
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 space-x-3 ">


            <x-link-nav :href="route('types.recipes', [
                'productDetailId' => $recipe->product_detail_id,
            ])" :active="request()->routeIs('types.recipes', [
                'productDetailId' => $recipe->product_detail_id,
            ])" icon="fa-solid fa-seedling">{{ $recipe->name }}</x-link-nav>


        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2 space-x-3">

            <x-link-nav :href="route('types.recipes', [
                'productDetailId' => $recipe->product_detail_id,
            ])" :active="request()->routeIs('types.recipes', [
                'productDetailId' => $recipe->product_detail_id,
            ])" icon="fa-solid fa-seedling">{{ $recipe->name }}</x-link-nav>

        </div>




    </div>
@endSection

@section('content')
    <div class="flex flex-col h-full  ">
        <div class="flex justify-start mr-2 mt-4 border-b border-gray-200">
            <x-heading value="اضافة مادة خام للوصفة" />
        </div>

        <div class="flex-1 flex flex-col  overflow-y-auto custom-scroll md:items-center">
            <div class=" md:w-lg  lg:w-3xl">
                <form action="{{ route('types.storeRecipeDetail') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        @if (session('error'))
                            <x-alert-danger value="{{ session('error') }}" />
                        @endif

                        @if (session('success'))
                            <x-alert-sucess value="{{ session('success') }}" />
                        @endif
                    </div>

                    <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">


                    <div class="md:w-lg  lg:w-3xl mt-5 m-auto relative flex flex-col " dir="rtl">
                        <select
                            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                            name="raw_material_id">
                            <option value="0">الرجاء اختيار المادة الخام </option>
                            @foreach ($rawMetarials as $rawMetarial)
                                <option value="{{ $rawMetarial->id }}">{{ $rawMetarial->name }} - {{ $rawMetarial->unit }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <x-floatingLabelInput id="quantity" name="quantity" labelValue="الكمية" icon="fa-solid fa-hashtag" />

                    <div class="flex justify-center mt-5">
                        <x-primary-button>اضافة</x-primary-button>
                    </div>

                </form>

            </div>




        </div>
    </div>
@endSection
