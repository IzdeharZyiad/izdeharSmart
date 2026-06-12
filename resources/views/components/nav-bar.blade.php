<div x-data="{ open: false }">
    <button type="button" @click="open = !open" class="hover:cursor-pointer">
        <i class="fa-solid fa-bars text-green-900 text-xl"></i>
    </button>

    <div x-show="open" x-cloak x-transition @click.outside="open = false"
        class="absolute left-0 mt-2 w-40 bg-white border rounded shadow-md p-2">

        <div class="flex flex-col">
            <!-- close-->
            <div>
                <button @click="open = !open" class="flex justify-start mr-2"><i
                        class="fa-solid fa-xmark text-green-900 text-lg"></i></button>
            </div>

            <!-- userName -->
            <div class="flex mt-4">
                <img src="https://i.pravatar.cc/150" class="w-9 h-9 rounded-full object-cover" />
                <div class="text-gray-800 font-medium mr-2 mt-1">
                    <a href="{{ route('settings') }}">{{ session('adminName') }}</a>
                </div>

            </div>
            <!-- message -->
            <div class="flex mt-4 mr-2 pb-2 border-b  border-gray-200 ">
                <a> <i class="fa-solid fa-bell text-gray-500 fa-lg "></i></a>
                <div class="text-gray-800 font-medium mr-2 mt-1">الاشعارات</div>
            </div>

            <div class="flex mt-4 mr-2 ">
                <a> <i class="fa-solid fa-arrow-right-from-bracket text-gray-500 fa-lg mt-4"></i></a>
                <div class="text-gray-800 font-medium mr-2 mt-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">تسجيل الخروج</button>
                    </form>

                </div>
            </div>



        </div>


    </div>

</div>
