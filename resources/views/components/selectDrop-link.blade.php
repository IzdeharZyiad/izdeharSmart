@props([ 'value'=>''  ])
<a  @click.prevent="selected = '{{ $value }}' , open = false" class = 'px-4 py-2 hover:bg-gray-100 cursor-pointer'>
 {{ $slot ?: $value }}

</a>

