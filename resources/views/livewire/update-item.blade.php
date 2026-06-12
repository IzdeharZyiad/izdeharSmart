<div>


    <div class="fixed inset-1 z-[1550]  mt-40 max-w-sm h-70 md:max-w-lg lg:max-w-xl md:mr-40 lg:mr-90" ">
        <div class="w-full bg-white border border-green-600 shadow-xl shadow-gray-700/50   flex  flex-col ">

            <div class="w-full">
                <!-- close icon -->
                <div>
                    <button wire:click="$dispatch('closeModal')"
                        class="text-gray-900 text-4xl mr-4 mt-2 transition hover:text-green-900 hover:cursor-pointer">
                        &times;
                    </button>
                </div>
                <div class="flex justify-center ">
                    <x-heading value="تعديل فئة " />
                </div>
            </div>

            <div class="flex-1 mt-2">


                <form wire:submit.prevent="updateName">

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


        <x-floatingLabelInput wire:model="itemName" id="" name="" labelValue="اسم الفئة" />
        @if ($validateMessage)
            <div class="w-full flex justify-center text-red-500 text-sm">
                {{ $validateMessage }}
            </div>
        @endif


        <div class="flex mt-8  w-full justify-center pb-4">
            <x-primary-button>تعديل</x-primary-button>
        </div>

        </form>





    </div>




</div>



</div>



</div>
