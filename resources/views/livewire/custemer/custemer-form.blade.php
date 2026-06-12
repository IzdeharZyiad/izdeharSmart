<div>
    <button wire:click="openModal"
        class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
        <i class="fa-solid fa-user-plus   text-sm "></i>
        <span class="hidden md:block mr-2">اضافة زبون</span>
    </button>

    @if ($open)
        <div
            class="fixed  inset-1 z-[1550]  mt-15 overflow-y-auto custom-scroll  h-100 md:w-lg lg:w-xl md:mr-40 lg:mr-90">
            <div
                class="w-full  overflow-y-auto   bg-white border border-green-600 shadow-xl shadow-gray-700/50   flex  flex-col ">

                <div class="w-full">
                    <!-- close icon -->
                    <div>
                        <button wire:click="closeModal"
                            class="text-gray-900 text-4xl mr-4 mt-2 transition hover:text-green-900 hover:cursor-pointer">
                            &times;
                        </button>
                    </div>
                    <div class="flex justify-center ">
                        <x-heading value="اضافة زبون " />
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


                        <x-floatingLabelInput wire:model="name" id="" name="name" labelValue="اسم الزبون" />
                        <x-floatingLabelInput wire:model="idNumber" id="" name="idNumber"
                            labelValue="رقم الهوية" icon="fa-solid fa-id-card" />
                        <x-floatingLabelInput wire:model="phoneNumber" id="" name="phoneNumber"
                            labelValue="رقم الهاتف" icon="fa-solid fa-phone" />

                        <x-floatingLabelInput wire:model="balance" id="" name="balance"
                            labelValue="رصيد له(+) \ رصيد عليه (-)" icon="fa-solid fa-money" />






                        <div class="flex mt-8  w-full justify-center pb-4">
                            <x-primary-button>تأكيد الاضافة</x-primary-button>
                        </div>

                    </form>

                </div>




            </div>



        </div>
    @endif

</div>
