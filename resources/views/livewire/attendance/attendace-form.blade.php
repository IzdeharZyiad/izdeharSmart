<div>


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
                        <x-heading value="تسجيل حضور او غياب " />
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

                        <select
                            class="w-full  px-2.5 pb-2.5 pt-4 border border-gray-400 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                            wire:model="status" name="status">
                            <option value="">الرجاء تحديد حالة الموظف</option>
                            <option value="حضور">حضور</option>
                            <option value="غياب">غياب</option>



                        </select>








                        <div class="flex mt-8  w-full justify-center pb-4">
                            <x-primary-button>تأكيد </x-primary-button>
                        </div>

                    </form>

                </div>




            </div>



        </div>
    @endif

</div>
