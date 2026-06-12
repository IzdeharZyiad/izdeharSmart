document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',

         events: window.calendarEvents, // 👈 هون البيانات

        dateClick: function(info) {
            Livewire.dispatch('openAttendanceModal', info.dateStr);
        },
         eventClick: function(info) {
            Livewire.dispatch('openEditAttendance', info.event.id);
        }

     
    });

    calendar.render();
});