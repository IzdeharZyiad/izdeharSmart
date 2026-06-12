<x-layouts.types>

    <!-- cards -->
    <div class="flex flex-col md:grid grid-cols-3">
        <div class="border-b md:border-l  border-gray-200">
            <x-card-nav icon="fa-solid fa-building" text="أفضل قسم مبيعًا اليوم" value=" " />
        </div>
        <div class="border-b  md:border-l border-gray-200">
            <x-card-nav icon="fa-solid fa-money-bill" text="إجمالي المبيعات اليوم" value=" " />
        </div>
        <div class="border-b md:border-l  border-gray-200">
            <x-card-nav icon="fa-solid fa-money-bill" text="صافي الربح اليومي" value=" " />
        </div>

    </div>

    <livewire:types-swiper />




    @section('script')
        <script>
            let swiperInstance = null;

            function initSwiper() {
                if (swiperInstance) swiperInstance.destroy(true, true);

                swiperInstance = new Swiper(".mySwiper", {
                    slidesPerView: 3,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
            }

            document.addEventListener("livewire:load", function() {
                initSwiper();
            });

            Livewire.on("refreshSwiper", () => {
                initSwiper();
            });

            document.addEventListener("DOMContentLoaded", function() {
                console.log("DOM loaded");

                Livewire.on("refreshSwiper", () => {
                    console.log("Swiper event received");
                    initSwiper();
                });
            });
        </script>
    @endsection

</x-layouts.types>
