<li x-data="{ open: false }">

    <!-- العنوان الرئيسي -->
    <div @click="open = !open" class="cursor-pointer">
        <x-col-link text="الاشخاص" icon="fa-solid fa-chevron-down" />
    </div>

    <!-- العناصر اللي تحت -->
    <ul x-show="open" x-transition class="mr-4 mt-2 space-y-2">
        <li> <x-col-link icon="fa fa-soild fa-users" text="التجار" :href="route('sellers')" :active="request()->routeIs('sellers')" /> </li>
        <li> <x-col-link icon="fa fa-soild fa-users" text="الزبائن" :href="route('custemers')" :active="request()->routeIs('custemers')" /> </li>
        <li> <x-col-link icon="fa fa-soild fa-users" text="الموظفين" :href="route('users')" :active="request()->routeIs('users')" /> </li>
    </ul>

</li>
