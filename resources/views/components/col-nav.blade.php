  <ul class="mt-4 space-y-4 text-center ">

      <span class="hidden">الرئيسية</span>

      <li><x-col-link icon="fa fa-soild fa-home" :href="route('dashboard')" :active="request()->routeIs('dashboard')" text="الرئيسية" /></li>
      <x-pepole-nav />

      <li> <x-col-link icon="fa fa-soild fa-building" text="الأقسام" :href="route('types')" :active="request()->routeIs('types')" /> </li>
      <li> <x-col-link icon="fa fa-soild fa-seedling" text="المواد الخام" :href="route('rawMaterials')" :active="request()->routeIs('rawMaterials')" />
      </li>
      <li> <x-col-link icon="fa fa-soild fa-cart-shopping" text="المشتريات" :href="route('purchases')" :active="request()->routeIs('purchases')" /> </li>
      <li> <x-col-link icon="fa fa-soild fa-truck" text="المبيعات" :href="route('sales')" :active="request()->routeIs('sales')" /> </li>
      <li> <x-col-link icon="fa fa-soild fa-address-book" text="الطلبات" /> </li>
      <li> <x-col-link icon="fa fa-soild fa-boxes-stacked" :href="route('stocks')" :active="request()->routeIs('stocks')" text="المخزون" /> </li>
      <li> <x-col-link icon="fa fa-soild fa-money-bill" text="المالية" :href="route('financials')" :active="request()->routeIs('financials')" /> </li>
      <li> <x-col-link icon="fa fa-soild fa-file" text="التقارير" :href="route('reports')" :active="request()->routeIs('reports')" /> </li>



      <span class="hidden mt-8  text-gray-500">اخرى:</span>
      <li class="mt-10"> <x-col-link icon=" fa fa-soild fa-gear" :href="route('settings')" :active="request()->routeIs('settings')"
              text="الاعدادات" />
      </li>


  </ul>
