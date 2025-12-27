@props(['title' , 'icon'=>'fa fa-user'])
 <div class="grid grid-cols-2  w-full h-[40px] ">
            <div class="flex items-center mr-6 mt-4 selection:bg-green-700 selection:text-white">
                <i class="{{$icon}} text-green-900 ml-2 fa-lg "></i>

                <h1 class="text-green-900 text-xl font-medium">{{$title}}</h1>
            </div>
 </div>