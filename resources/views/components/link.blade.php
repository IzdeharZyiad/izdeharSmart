 @props([
     'href' => '',
     'value' => '',
 ])

 @php
     $classes = "flex-1 bg-white border border-gray-300 hover:bg-[#3E6E5C] hover:text-white text-gray-700 font-medium py-2
 px-4 rounded-lg transition duration-150 ease-in-out";
 @endphp

 <a {{ $attributes->merge(['class' => $classes]) }} href="{{ $href }}">
     {{ $value }}
 </a>
