<div>

    <button wire:click="openModal"
        class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
        <i class="fa-solid fa-building   text-sm "></i>
        <span class="hidden md:block mr-2">اضافة قسم</span>
    </button>


    @if ($open)
        <div class="fixed inset-1 z-[1550]  mt-40 max-w-sm h-70 md:max-w-lg lg:max-w-xl md:mr-40 lg:mr-90">
            <div class="w-full    bg-white border border-green-600 shadow-xl shadow-gray-700/50   flex  flex-col ">

                <div class="w-full">
                    <!-- close icon -->
                    <div>
                        <button wire:click="closeModal"
                            class="text-gray-900 text-4xl mr-4 mt-2 transition hover:text-green-900 hover:cursor-pointer">
                            &times;
                        </button>
                    </div>
                    <div class="flex justify-center ">
                        <x-heading value="اضافة قسم " />
                    </div>
                </div>

                <div class="flex-1 mt-2">



                    <form wire:submit.prevent="save">

                        @if ($successMessage)
                            <div class="text-green-600 text-sm">
                                <x-alert-sucess value="{{ $successMessage }}" />
                            </div>
                        @endif

                        @if ($errorMessage)
                            <div class="text-red-500 text-sm">
                                <x-alert-danger value="{{ $errorMessage }}" />
                            </div>
                        @endif


                        <x-floatingLabelInput wire:model="name" id="" name="" labelValue="اسم القسم" />
                        @if ($validateMessage)
                            <div class="w-full flex justify-center text-red-500 text-sm">
                                {{ $validateMessage }}
                            </div>
                        @endif


                        <div class="flex mt-8  w-full justify-center pb-4">
                            <x-primary-button>تأكيد الاضافة</x-primary-button>
                        </div>

                    </form>

                </div>




            </div>



        </div>
    @endif
</div>
