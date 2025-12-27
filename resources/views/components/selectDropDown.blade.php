

   <div x-data="{ open: false, selected: '{{ $selected ?? '' }}',  holder: '{{ $holder }}'  , name:'{{$name}}' , value:''}" class="relative" @click.outside="open = false" @keydown.escape.window="open = false">
      <button @click.prevent="open = !open"
           class="flex px-2.5 pb-3.5 pt-3.5   border-2 border-gray-300 w-full focus:border-[#2F5D50]">
           <svg class="ml-1 h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
               <path
                   d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.356a.75.75 0 111.14.98l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" />
           </svg>
           <span x-text="selected ? selected : holder "
               :class="selected ==='' ? 'text-gray-500 text-sm font-bold' : 'text-black'"></span>
       </button>
 

              <div class="absolute w-full bg-white shadow mt-2 border z-50 flex flex-col " x-show="open" x-cloak>
                {{$slot}}

              </div>

                         <input type="hidden" :name="name" :value="selected">



</div>