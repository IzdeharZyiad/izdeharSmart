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

                @foreach ($custemers as $custemer)
                    <div class="swiper-slide mt-4">
                        <div class="bg-white rounded-2xl shadow-lg border border-green-600 py-6 px-6">

                            <div class="px-6 pb-3 text-center">
                                <h3 class="text-xl font-bold">
                                    {{ $custemer->name }}
                                </h3>
                                <p class="text-[#558F67] mt-6 font-medium">{{ $custemer->phoneNumber }}</p>
                            </div>

                            <div class="mt-6 flex justify-center gap-2">

                                <button wire:click="updateId({{ $custemer->id }})"
                                    class="flex-1 bg-[#8BC6A0] hover:bg-[#3E6E5C] text-white py-2 px-4 rounded-lg text-center">
                                    عرض
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
        <livewire:custemer.update-custemer :custemerId="$custemerId" />
    @endif



</div>
