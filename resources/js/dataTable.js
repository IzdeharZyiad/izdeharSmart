$(document).ready(function () {
  
  $('#myTable').DataTable({
      order: [], // 👈 هذا السطر هو الحل
    language: {
     url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
       search: "",
      searchPlaceholder: "بحث"
    },
    columnDefs: [
        
        {
            targets: 0,      // أول عمود (يبدأ من 0)
            orderable: false ,// تعطيل الترتيب
            className: 'text-center',
        },

         {
            targets: 5,      // أول عمود (يبدأ من 0)
            orderable: false ,// تعطيل الترتيب
            className: 'text-center',
        }
    ],
    pageLength: 5,
    lengthMenu: [5, 10, 25, 50, 100]
  });
});