 @props([
    'icon' => '',
    'text' => '',
    'value' => ''
])

 <div class="flex gap-2  mt-6 justify-center">
     <i class="{{$icon}} mt-1 text-gray-500"></i>

     <p class="text-gray-500">
        {{$text}}
     </p>
 </div>
 <div class="flex justify-center mt-2 pb-4">
     <h1 class="font-bold ">
        {{$value}}
     </h1>
 </div>
