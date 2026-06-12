@props(['icon' => 'fas fa-user', 'text' => null, 'active'])
@php
    $classes =
        $active ?? false
            ? 'bg-green-800 p-2 rounded-lg text-white  md:px-2  '
            : 'border-green-800 text-green-900 hover:bg-green-800  hover:p-2 
            hover:cursor-pointer hover:rounded-lg hover:text-white';

    $span_class = $active ?? false ? 'hidden md:inline-block md:px-2 ' : 'hidden md:inline-block  rounded-lg   px-2';

@endphp

<!--بستخدم ال group عشان يعرضلي الاسم بس اعمل hover -->
<a {{ $attributes->merge(['class' => $classes]) }}>
    <span><i class="{{ $icon }} text-md"></i></span>
    <span {{ $attributes->merge(['class' => $span_class]) }}>
        {{ $text }}</span>
</a>
