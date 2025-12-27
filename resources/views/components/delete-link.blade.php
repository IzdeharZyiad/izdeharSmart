@props(['active' , 'icon' => 'fa-solid fa-trash' , 'text'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center  text-md font-bold px-1 pt-2 mt-2 border-b-2 border-green-800 text-green-900'
            :'inline-flex items-center text-md font-medium  mr-4 text-red-600
             hover:text-red-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
     <i class="{{ $icon }} ml-2 text-sm :text-inherit "></i>
    {{ $text }}

    
</a>




    