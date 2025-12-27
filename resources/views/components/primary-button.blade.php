<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'flex justify-center w-[200px] px-4 py-2 
            bg-[#8BC6A0] 
            dark:bg-gray-200 
            border border-transparent  
            text-[20px] text-white font-serif
            dark:text-gray-800 uppercase tracking-widest
            hover:bg-[#3E6E5C] dark:hover:bg-white focus:bg-gray-700
            dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 
            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
            dark:focus:ring-offset-gray-800 transition ease-in-out duration-150',
    ]) }}>
    {{ $slot }}
</button>
