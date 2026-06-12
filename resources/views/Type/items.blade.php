<x-layouts.items :typeId="$typeId" :typeName="$typeName">

    <!-- cards -->
    <div class="flex flex-col ">
        <div class="border-b md:border-l  border-gray-200">
            <x-card-nav icon="fa-solid fa-building" text="أفضل فئة مبيعًا اليوم" value="" />
        </div>


    </div>
    <livewire:items-swiper :typeId=$typeId />

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

</x-layouts.items>
