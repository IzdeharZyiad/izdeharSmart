<div>


    <div class="fixed inset-1 z-[1550]  mt-15  overflow-y-auto custom-scroll h-100 md:w-lg lg:w-xl md:mr-40 lg:mr-90" ">
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
                    <x-heading value="تعديل زبون " />
                </div>
            </div>

            <div class="flex-1 mt-2">


                   <form wire:submit.prevent="updateCustemer">

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


        <x-floatingLabelInput wire:model="name" id="" name="name" labelValue="اسم التاجر" />
        <x-floatingLabelInput wire:model="idNumber" id="" name="idNumber" labelValue="رقم الهوية"
            icon="fa-solid fa-id-card" />
        <x-floatingLabelInput wire:model="phoneNumber" id="" name="phoneNumber" labelValue="رقم الهاتف"
            icon="fa-solid fa-phone" />

        <x-floatingLabelInput wire:model="balance" id="" name="balance" labelValue="دين الزبون"
            icon="fa-solid fa-money" readonly />







        <div class="flex mt-8  w-full justify-center pb-4">
            <x-primary-button>تعديل</x-primary-button>
        </div>

        </form>





    </div>




</div>



</div>



</div>
