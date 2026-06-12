<div class="flex-1 flex flex-col w-full custom-scroll overflow-y-auto border-t border-gray-200 mx-auto shadow-lg">
    <!-- Search -->
    <div class="flex justify-center w-full p-2">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث"
            class="w-full p-2 border border-green-800 focus:border-green-900 focus:ring-0 rounded-lg" />
    </div>

    <div class="flex-1 mt-2 ">
        <!-- Swiper -->
        <div class="swiper mySwiper" dir="rtl">
            <div class="swiper-wrapper">

                @foreach ($products as $product)
                    <div class="swiper-slide  rounded-xl  border border-gray-200  mr-2">

                        <div class="h-32 bg-gradient-to-r from-green-500 to-lime-600 relative rounded-t-xl">
                            <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                                @if ($product->productImg != null)
                                    <img class="h-24 w-24 rounded-full border-2 border-gray-200 "
                                        src="{{ asset('storage/' . $product->productImg) }}" alt="Profile picture">
                                @else
                                    <img class="h-24 w-24 rounded-full border-4 border-white bg-black object-cover"
                                        src="{{ Vite::asset('resources/images/iconUser.png') }}" alt="Profile picture">
                                @endif
                            </div>
                        </div>
                        <!-- Profile Info -->
                        <div class="pt-16 pb-8 px-6 text-center">
                            <h3 class="text-xl font-bold "> {{ $product->name }} </h3>
                            <p class="text-[#558F67] font-medium"></p>




                            <!-- Contact Buttons -->
                            <div class="mt-8 flex justify-center space-x-4   ">
                                <button wire:click="updateId({{ $product->id }})"
                                    class="flex-1 bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white py-2 px-4 rounded-lg text-center">
                                    عرض
                                </button>

                                <x-link
                                    href="{{ route('types.items.products.productDetails', ['itemId' => $product->item_id, 'productId' => $product->id]) }}"
                                    value="الاحجام والكميات " />


                                <button class="flex-1 bg-red-400 hover:bg-red-600 text-white py-2 px-4 rounded-lg">
                                    حذف
                                </button>

                            </div>


                        </div>
                    </div>
                @endforeach

            </div>

            <!-- الأسهم -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- pagination -->

            <div class="swiper-pagination "></div>


        </div>


    </div>

    @if ($open)
        <livewire:update-product :productId="$productId" />
    @endif
</div>
