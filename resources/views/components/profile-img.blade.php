<div x-data="{ open: false }" class="relative inline-block">
    <div class="flex items-center space-x-2 ">
        <img src="https://i.pravatar.cc/150" class="w-9 h-9 rounded-full object-cover" />
        <div class="text-gray-800 font-medium">{{ session('adminName') }}</div>
        <button type="button" @click="open = !open">
            <svg class="w-5 h-5 text-gray-600 hover:cursor-pointer hover:text-green-900" fill="none"
                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-cloak x-transition @click.outside="open = false"
        class="absolute left-0 mt-2 w-40 bg-white border rounded shadow-md p-2">
        <div>
            <button @click="open = !open" class="flex justify-start mr-2"><i
                    class="fa-solid fa-xmark text-green-900 text-lg"></i></button>

            <!-- userName -->
            <div class="flex mt-4">
                <img src="https://i.pravatar.cc/150" class="w-9 h-9 rounded-full object-cover" />
                <div class="text-gray-800 font-medium mr-2 mt-1">
                    <a href="{{ route('settings') }}">{{ session('adminName') }}</a>
                </div>

            </div>

            <!-- logout -->
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
