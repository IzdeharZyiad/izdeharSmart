import './bootstrap';
import './dataTable';

import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()


import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import 'datatables.net-dt';
import 'datatables.net-dt/css/dataTables.dataTables.css';



import.meta.glob([
    '../images/**',
]);
