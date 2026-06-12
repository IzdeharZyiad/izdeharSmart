
import './bootstrap';
import './dataTable';
import './swiper';
import './calendar';

import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()


import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import 'datatables.net-dt';
import 'datatables.net-dt/css/dataTables.dataTables.css';

import { initSwiper } from './swiper';

document.addEventListener("DOMContentLoaded", () => {
    initSwiper();
});

Livewire.on("refreshSwiper", () => {
    setTimeout(() => {
        initSwiper();
    }, 50);
});

import.meta.glob([
    '../images/**',
]);
