
<div x-data="{ open: false }" class="relative inline-block">
  <div class="flex items-center space-x-2 cursor-pointer">
   
    <button type="button" @click="open = !open">
      <i class="fa-solid fa-bell text-gray-500 fa-lg "></i>

               
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
