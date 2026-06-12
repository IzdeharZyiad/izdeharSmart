<div>
    <button wire:click="openModal"
        class="group flex items-center group
                             p-2  h-full rounded-md shadow-md
                                text-center text-green-900 border-2 border-gray-200 font-sm 
                                hover:bg-green-900 hover:text-white hover:cursor-pointer">
        <i class="fa-solid fa-money-bill   text-sm "></i>
        <span class="hidden md:block mr-2">اضافة مصروف</span>
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
                        <x-heading value="اضافة مصروف" />
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

                        <div>
                            <x-input-date name="dateToday" wire:modal="dateToday"
                                wire:change="updateDateToday($event.target.value)" value="{{ $dateToday }}" />


                            <x-floatingLabelInput id="day" name="dayName" labelValue="اليوم"
                                icon="fa-solid fa-calendar-days" value="{{ $day }}" readonly />

                        </div>

                        <x-floatingLabelInput wire:model="mount" id="" name="mount" labelValue="المبلغ"
                            icon="fa-solid fa-money" />

                        <div class=" mt-5 m-auto relative flex flex-col " dir="rtl">
                            <select
                                class="w-full  px-2.5 pb-2.5 pt-4 border-2 border-gray-300 focus:border-[#2F5D50] focus:outline-none focus:ring-0"
                                name="type" wire:model="type">
                                <option value="">الرجاء اختيار السبب</option>
                                <option value="ايجار محل">ايجار محل</option>
                                <option value="كهرباء">كهرباء</option>
                                <option value="ماء">ماء</option>
                                <option value="انترنت">انترنت</option>
                                <option value="هاتف">هاتف</option>
                                <option value="بنزين">بنزين</option>
                                <option value="سفر">سفر</option>
                                <option value="رواتب">رواتب </option>
                                <option value="صيانه">صيانه</option>



                            </select>

                        </div>




                        <div class="flex mt-8  w-full justify-center pb-4">
                            <x-primary-button>تأكيد الاضافة</x-primary-button>
                        </div>

                    </form>

                </div>




            </div>



        </div>
    @endif

</div>
