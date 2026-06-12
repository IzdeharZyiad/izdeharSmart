@extends('welcome')

@section('title')
    التجار
@endSection

@section('navbar-row')
    <div class=" flex flex-col justify-center md:hidden">
        <!-- center in sm -->
        <div class="flex mr-2 ">
            <x-link-nav :href="route('sellers')" :active="request()->routeIs('sellers')" icon="fa-solid fa-user">التجار</x-link-nav>

        </div>

    </div>
    <!-- center in md and above -->
    <div class="hidden  flex items-center  md:inline-flex ">

        <div class="flex mr-2">
            <x-link-nav :href="route('sellers')" :active="request()->routeIs('sellers')" icon="fa-solid fa-user">التجار</x-link-nav>

        </div>




    </div>
@endSection


@section('content')
    <div class="flex flex-col h-full ">

        <div class=" mt-4 h-[40px]  ">

            <div class="grid grid-cols-[0.5fr_1fr] h-full">
                <!--- name -->
                <div class="flex items-center mr-2">
                    <h1 class="text-green-900 text-sm font-medium">قائمة التجار</h1>
                </div>
                <div class="flex justify-end space-x-4  ml-2 ">
                    <a
                        class="flex group items-center justify-center p-2 
                    rounded-lg shadow-md border-2 border-gray-200 
                    hover:bg-green-900 hover:text-white hover:cursor-pointer"><i
                            class="fa-solid fa-arrow-down text-md  "></i>
                        <span class="hidden md:block mr-2">تنزيل</span>
                    </a>

                    <livewire:seller.seller-form />


                </div>

            </div>

        </div>
        <!-- مكان ال swipper اللي راح تتمدد-->
        <div class="flex-1 h-full flex flex-col  mt-2 border-t border-gray-200  overflow-y-auto">

            <livewire:Seller.seller-swiper />



        </div>







    </div>
@endSection

@section('script')
    <script>
        let swiperInstance = null;

        function initSwiper() {
            setTimeout(() => {
                if (swiperInstance) {
                    swiperInstance.destroy(true, true);
                }

                swiperInstance = new Swiper(".mySwiper", {
                    slidesPerView: 3,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    observer: true,
                    observeParents: true,
                });

            }, 100);
        }

        // أول تحميل
        document.addEventListener("livewire:load", function() {
            initSwiper();
        });

        // بعد أي تحديث من Livewire (الأهم 🔥)
        Livewire.hook('message.processed', () => {
            initSwiper();
        });

        // لو بدك trigger مباشر
        Livewire.on('refreshSwiper', () => {
            initSwiper();
        });
    </script>
@endsection
