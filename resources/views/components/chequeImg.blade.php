<div x-data="{ open: false }" class="relative inline-block">
    <div class="flex items-center space-x-2 ">

        <button type="button" @click="open = !open">
            <i class="fa-solid fa-bell text-gray-500 fa-lg hover:cursor-pointer hover:text-green-900"></i>


        </button>
    </div>

    <div x-show="open" x-cloak x-transition @click.outside="open = false"
        class="absolute left-0 mt-2 w-40 bg-white border rounded shadow-md p-2">
        <!-- close-->
        <div>
            <button @click="open = !open" class="flex justify-start mr-2"><i
                    class="fa-solid fa-xmark text-green-900 text-lg"></i></button>
        </div>

        <div>

        </div>
    </div>
</div>
