@props(['active' , 'icon' => 'fas fa-user'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center  text-md font-bold px-1 pt-2 mt-2 border-b-2 border-green-800 text-green-900'
            :'inline-flex items-center text-md font-medium" px-1 pt-2 mt-2 border-b-2  border-transparent  leading-5 text-green-950
             hover:border-green-800 hover:text-green-700  hover:pb-4 hover:mt-4  transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
     <i class="{{ $icon }} ml-2 mb-1 text-md :text-inherit "></i>
    {{ $slot }}

    
</a>




    