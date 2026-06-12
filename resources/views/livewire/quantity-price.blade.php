<div>
    <x-floatingLabelInput id="quantity" name="quantity" labelValue="الكمية" wire:model="quantity"
        wire:change="updateQuantity($event.target.value)" icon="fa-solid fa-hashtag" />
    <x-floatingLabelInput id="price" name="price" labelValue="سعر القطعة" wire:model="price"
        wire:change="updatePrice($event.target.value)" icon="fa-solid fa-money-bill" />
    <x-floatingLabelInput id="totalPrice" name="totalPrice" labelValue="السعر الكلي" value="{{ $totalPrice }}"
        icon="fa-solid fa-money-bill" readonly />
</div>
