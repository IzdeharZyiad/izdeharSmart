<div>
    <livewire:date-day />

    <x-floatingLabelInput id="finalPrice" name="finalPrice" labelValue="المبلغ المطلوب دفعه" icon="fa-solid fa-money-bill"
        readonly value="{{ $finalPrice }}" />

    <x-floatingLabelInput id="amount" name="amount" labelValue="المبلغ" icon="fa-solid fa-money-bill"
        wire:model="amount" />




</div>





</div>
