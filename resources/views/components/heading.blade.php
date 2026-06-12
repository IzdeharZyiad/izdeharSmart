<p {{ $attributes->merge([
    'class' => 'text-center font-bold text-xl md:text-2xl text-green-900 font-serif',
]) }}>
    {{ $attributes->get('value') }}
</p>
