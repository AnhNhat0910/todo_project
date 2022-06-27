$(document).ready(function () {
   $('#listTable').DataTable({
      paging: false,
      "ordering": false,
      // "bPaginate": false,
      // "bLengthChange": false,
      "bInfo": false,
      // "bAutoWidth": false
      "language": {
         "emptyTable": "No task available",
       }
   });
});
