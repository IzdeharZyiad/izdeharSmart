<div>
    <x-input-date name="dateToday" wire:modal="dateToday" wire:change="updateDateToday($event.target.value)"
        value="{{ $dateToday }}" />

    <x-floatingLabelInput id="day" name="dayName" labelValue="اليوم" icon="fa-solid fa-calendar-days"
        value="{{ $day }}" readonly />

</div>
