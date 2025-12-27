
<div x-data="{ open: false }" class="relative inline-block">
  <div class="flex items-center space-x-2 cursor-pointer">
    <img src="https://i.pravatar.cc/150" class="w-9 h-9 rounded-full object-cover" />
    <div class="text-gray-800 font-medium">المستخدم</div>
    <button type="button" @click="open = !open">
     <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
    </button>
  </div>

  <div 
    x-show="open" x-cloak
     x-transition
     @click.outside="open = false"
    class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-md p-2">
    izdehar
  </div>
</div>
