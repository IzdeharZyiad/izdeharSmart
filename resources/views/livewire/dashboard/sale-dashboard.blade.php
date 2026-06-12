 <div class="flex flex-col h-full  ">

     <div class=" mt-4 h-[40px]  ">

         <div class="flex gap-2">
             <button wire:click="$set('filter', 'today')"
                 class="{{ $filter == 'today' ? 'px-4 py-2 mr-4 rounded-lg bg-green-900 text-white' : 'bg-gray-100 text-black px-4 py-2 mr-4 rounded-lg bg-gray-100' }}">
                 اليوم
             </button>

             <button wire:click="$set('filter', 'week')"
                 class="{{ $filter == 'week' ? 'px-4 py-2 rounded-lg bg-green-900 text-white' : 'bg-gray-100 text-black px-4 py-2 rounded-lg bg-gray-100' }}">
                 هذا الأسبوع
             </button>

             <button wire:click="$set('filter', 'mounth')"
                 class="{{ $filter == 'mounth' ? 'px-4 py-2 rounded-lg bg-green-900 text-white' : 'bg-gray-100 text-black px-4 py-2 rounded-lg bg-gray-100' }}">
                 هذا الشهر
             </button>

             <button wire:click="$set('filter', 'specified')"
                 class="{{ $filter == 'specified' ? 'px-4 py-2 rounded-lg bg-green-900 text-white' : 'bg-gray-100 text-black px-4 py-2 rounded-lg bg-gray-100' }}">
                 مخصص
             </button>
             @if ($filter == 'specified')
                 <div class="flex -mt-5 gap-2">
                     <x-floatingLabelInput type="date" id="firstDate" wire:model="firstDate" name="firstDate"
                         labelValue="بداية الفترة" icon="fa-solid fa-calendar-days"
                         wire:change="updateFirstDate($event.target.value)" />

                     <x-floatingLabelInput type="date" id="endDate" name="endDate" wire:model="endDate"
                         labelValue="نهاية الفترة" wire:change="updateEndDate($event.target.value)"
                         icon="fa-solid fa-calendar-days" />

                 </div>
             @endif
         </div>

     </div>

     <!-- مكان ال swipper اللي راح تتمدد-->
     <div class="flex-1 h-full flex flex-col  mt-4 border-t border-gray-200  overflow-y-auto custom-scroll">

         <!-- cards -->
         <div class="flex flex-col md:grid grid-cols-3 md:h-25">
             <div class="border-b md:border-l  border-gray-200">
                 <x-card-nav icon="fa-solid fa-money-bill" text="قيمة المبيعات" value="{{ $sales_mount }}" />
             </div>
             <div class="border-b  md:border-l border-gray-200">
                 <x-card-nav icon="fa-solid fa-hashtag" text="عدد عمليات البيع" value="{{ $sale_count }}" />
             </div>
             <div class="border-b md:border-l  border-gray-200">
                 <x-card-nav icon="fa-solid fa-money-bill" text="الربح" value="{{ $sales_profit }}" />
             </div>

         </div>

         <div class="flex flex-col   md:grid grid-cols-3">

             <div class="border border-gray-200 h-60 "> <canvas id="pieChart"></canvas></div>
             <div class="border border-gray-200 h-60"> <canvas id="BarChart"></canvas></div>
             <div class="border border-gray-200 h-60 "> <canvas id="lineChart"></canvas></div>


         </div>



     </div>



 </div>
