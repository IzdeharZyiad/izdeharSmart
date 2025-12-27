@props(['id', 'name', 'type' => 'text', 'placeholder' => ' ', 'icon' => 'fas fa-user', 'labelValue' , 'value'])

<div class="max-w-sm md:max-w-md mt-5 m-auto relative flex flex-col " dir="rtl">



    <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" 
     {{-- value أولية فقط --}}
    value="{{ $type === 'date' ? $value : '' }}"
     {{ $attributes }}  x-bind:disabled="disabled" 
        {{ $attributes->merge([
            'class' =>
                'peer  px-2.5 pb-2.5 pt-4 lg:w-full bg-transparent appearance-none border-2 border-gray-300 
                 
                                 focus:outline-none focus:ring-0 focus:border-[#2F5D50]' .
                ($errors->has($name) ? ' border-red-400  shadow-md ' : ''),
        ]) }}
        placeholder=" " >

    <label for="{{ $id }}"
        class=" absolute 
        text-xs  font-bold   duration-300 transform  scale-75  -translate-y-4  top-2 z-10 origin-[0] px-2 text-gray-500 
      peer-focus:text-[#2F5D50] peer-focus:px-1  
        peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 
        peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:bg-white">{{ $labelValue }}



        @if ($errors->has($name))
            <i class="fa-solid fa-circle-exclamation float-right pl-4 text-md text-red-500 mt-1"></i>
        @else
            <i class=" {{ $icon }} float-right pl-4 text-md mt-1"></i>
        @endif






    </label>


</div>
<x-input-error :messages="$errors->get($name)" class="mt-1 text-sm flex justify-center text-red-500" />
