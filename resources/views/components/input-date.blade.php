 @props([
     'name' => '',
     'value' => null,
 ])

 <div class="  m-auto flex flex-col mt-5">
     <input id="date" type="date" name="{{ $name }}" value="{{ $value }}"
         max="{{ now()->setTimezone('Asia/Gaza')->format('Y-m-d') }}" {{ $attributes }} {{-- هذا السطر مهم لتمرير wire:model وغيره --}}
         class="border-2 border-gray-300 px-2.5 pb-2.5 pt-4    focus:outline-none focus:ring-0 focus:border-[#2F5D50]" />
 </div>
