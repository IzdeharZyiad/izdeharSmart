<div x-data="{ open: false }" class="mr-2 ">
    <button type="button" @click="open = !open" class="hover:cursor-pointer ">
        <span class="text-green-900 ">لوحات النظام</span>
        <i class="fa-solid fa-chevron-down text-green-900 mt-2 text-sm
         "></i>
    </button>

    <div x-show="open" x-cloak x-transition @click.outside="open = false"
        class="absolute right-8 mr-8 mt-2 w-16 hover:w-40 bg-white border rounded shadow-md p-2">

        <div class="flex flex-col  ">
            <!-- close-->
            <div>
                <button @click="open = !open" class="flex justify-start mr-2"><i
                        class="fa-solid fa-xmark text-green-900 text-lg"></i></button>


            </div>

            <div>
                <ul class="mt-4 space-y-4 text-center ">
                    <li> <x-col-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="fa fa-soild fa-home" text="الرئيسية" />
                    </li <li> <x-col-link :href="route('purchaseDashboard')" :active="request()->routeIs('purchaseDashboard')" icon="fa fa-soild fa-cart-shopping"
                        text=" المشتريات" /> </li>
                    <li> <x-col-link :href="route('saleDashboard')" :active="request()->routeIs('saleDashboard')" icon="fa fa-soild fa-truck" text=" المبيعات" />
                    </li>
                    <li> <x-col-link :href="route('stockDashboard')" :active="request()->routeIs('stockDashboard')" icon="fa fa-soild fa-boxes-stacked"
                            text=" المخزون" /> </li>
                </ul>
            </div>








        </div>


    </div>

</div>
