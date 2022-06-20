<!-- jQuery -->
<script src="{{url('')}}/layout/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('')}}/layout/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('')}}/layout/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- overlayScrollbars -->
<script src="{{url('')}}/layout/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('')}}/layout/dist/js/adminlte.min.js"></script>

<!-- Select2 -->
<script src="{{url('')}}/layout/plugins/select2/js/select2.full.min.js"></script>
<!-- Logelite -->
<script src="{{url('')}}/script.js"></script>

<script>
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  $('.logout-link').on('click', function() {
    if (confirm('Are you sure to logout?')) {
      return true;
    }
    return false;
  });
</script>

<script>
  $(document).ready(function() {
    $.get("{{url('')}}/admin/manage/document/user/get-bages", function(data, status){
    $('#badges').html(data);
  });

    $.get("{{url('')}}/admin/manage/users/assign-task/get-assign-badges", function(data, status) {
      $('#admin-badges-assignTask').html(data);
    });

    $.get("{{url('')}}/admin/manage/users/feedback/feed-badges", function(data, status){
    $('#admin-badges-feedback').html(data);
  });
  

  });
</script>

<!-- SweetAlert2 -->
<script src="{{url('')}}/layout/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="{{url('')}}/layout/plugins/toastr/toastr.min.js"></script>


<!-- DataTables  & Plugins -->
<script src="{{url('')}}/layout/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('')}}/layout/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('')}}/layout/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('')}}/layout/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{url('')}}/layout/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{url('')}}/layout/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{url('')}}/layout/plugins/jszip/jszip.min.js"></script>
<script src="{{url('')}}/layout/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{url('')}}/layout/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{url('')}}/layout/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{url('')}}/layout/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{url('')}}/layout/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>