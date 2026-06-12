<x-layouts.products :itemId="$item->id" :typeId="$item->type_id" :itemName="$item->name" :typeName="$item->type->name">

    <livewire:products-swiper :itemId="$item->id" />

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

</x-layouts.products>
