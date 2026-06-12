 <div class="flex flex-col h-full  ">

     <div class=" mt-4 h-[40px]  ">

         <div class="flex gap-2">
             <button wire:click="$set('filter', 'today')"
                 class="{{ $filter == 'today' ? 'px-4 mr-4 py-2 rounded-lg bg-green-900 text-white' : 'bg-gray-100 text-black px-4 py-2 mr-4 rounded-lg bg-gray-100' }}">
                 اليوم
             </button>



         </div>

     </div>

     <!-- مكان ال swipper اللي راح تتمدد-->
     <div class="flex-1 h-full flex flex-col  mt-4 border-t border-gray-200  overflow-y-auto custom-scroll">

         <!-- cards -->
         <div class="flex flex-col md:grid grid-cols-4 md:h-25">
             <div class="border-b md:border-l  border-gray-200">
                 <x-card-nav icon="fa-solid fa-money-bill" text="قيمة المشتريات" value="{{ $purchase_mount }}" />
             </div>
             <div class="border-b  md:border-l border-gray-200">
                 <x-card-nav icon="fa-solid fa-money-bill" text="قيمة المبيعات" value="{{ $sales_mount }}" />
             </div>
             <div class="border-b md:border-l  border-gray-200">
                 <x-card-nav icon="fa-solid fa-money-bill" text="قيمةالمصروفات" value="{{ $expense_mount }}" />
             </div>

             <div class="border-b md:border-l  border-gray-200">
                 <x-card-nav icon="fa-solid fa-money-bill" text="الربح" value="{{ $profit }}" />
             </div>

         </div>

         <div class="flex flex-col   md:grid grid-cols-3">

             <div class="border border-gray-200 h-60 "> <canvas id="pieChart"></canvas></div>
             <div class="border border-gray-200 h-60"> <canvas id="BarChart"></canvas></div>
             <div class="border border-gray-200 h-60 "> <canvas id="lineChart"></canvas></div>


         </div>

         <div class="flex-1 flex flex-col    md:flex-row   md:grid grid-cols-2 ">
             <div class="flex flex-col space-y-2 md:w-lg">

                 <div class="flex  space-y-2 justify-center mr-2 mt-4 border-b border-gray-200">
                     <p class="text-green-900 font-bold text-lg">التزاماتي</p>
                 </div>

                 @foreach ($allMoneySellers as $allMoneySeller)
                     <div class="bg-white rounded-2xl shadow-lg border border-green-600">
                         <div class="text-center">
                             <h3 class="text-xl font-bold mt-4">
                                 التاجر: {{ $allMoneySeller['name'] }}
                             </h3>
                             <p class="text-[#558F67] mt-4 font-medium">دفعه مستحقة :
                                 {{ $allMoneySeller['amount'] }} </p>
                             <p class="text-[#558F67] mt-4 font-medium">التاريخ :{{ $allMoneySeller['date'] }} </p>
                             <p class="text-[#558F67]  mt-4 font-medium">النوع :{{ $allMoneySeller['type'] }} </p>
                         </div>
                     </div>
                 @endforeach









             </div>

             <div class="flex flex-col space-y-2 md:w-lg">

                 <div class="flex  space-y-2 justify-center mr-2 mt-4 border-b border-gray-200">
                     <p class="text-green-900 font-bold text-md">ديون الزبائن</p>
                 </div>

                 @foreach ($allMoneyCustemers as $allMoneyCustemer)
                     <div class="bg-white rounded-2xl shadow-lg border border-green-600">
                         <div class="text-center">
                             <h3 class="text-xl font-bold mt-4">
                                 الزبون: {{ $allMoneyCustemer['name'] }}
                             </h3>
                             <p class="text-[#558F67] mt-4 font-medium">دفعه مستحقة :
                                 {{ $allMoneyCustemer['amount'] }} </p>
                             <p class="text-[#558F67] mt-4 font-medium">التاريخ :{{ $allMoneyCustemer['date'] }} </p>
                             <p class="text-[#558F67]  mt-4 font-medium">النوع :{{ $allMoneyCustemer['type'] }} </p>
                         </div>
                     </div>
                 @endforeach






             </div>





         </div>



     </div>



 </div>
