<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ['title'=>'View Notifications'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    @include('user_template.nav')


    @include('user_template.aside')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0">View Notifications</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->


      <input type="hidden" id="hidden_token" value="{{csrf_token()}}">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="card-title">Notifications List</h3>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="notification-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Message</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Message</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>

    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="noti-message" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Notification Message</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->

  @include('user_template.scripts')

  <script src="{{url('')}}/htmlspecialchars_decode.js"></script>

  <!-- Page specific script -->
  <script>
    var intervalTimer;
    var taskInfoTbl;
    $(function() {
      $("#notification-tbl").DataTable({
        columnDefs: [{
          bSortable: false,
          targets: [1]
        }],
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#notification-tbl_wrapper .col-md-6:eq(0)');

      taskInfoTbl = $("#notification-tbl").DataTable();

      getTableInfoData(taskInfoTbl);



    });

    let isAjax = false;
    let formEle = "#work-start-form";
    let frmBtn = "#start-task-btn";




    function getTableInfoData(taskInfoTbl) {
      taskInfoTbl.clear().draw();
      let url = `{{url('')}}/ajax/notifications/fetch-list`;
      getAjaxData(taskInfoTbl, url, setTableData);
    }

    function setTableData(tbl_id, response) {

      let count = 0;
      let updateLastSeen = false;

      //for loop
      response.data.forEach((ele, idx) => {

        let message = trimStr(ele.notifications.message);

        if (message.length > 80)
          message = `<span>${message} <button class="btn btn-sm btn-link message-btn">
                  View 
                </button></span>
                <span class="message d-none">${n2br(ele.notifications.message)}</span>
                `;


        let eleType = `<div class="text-center"><i class="fas fa-envelope-open"></i></div>`;
        if (ele.notification_id > response.last_seen) {
          eleType = `<div class="text-danger text-center"><i class="fas fa-envelope"></i></div>`;
          updateLastSeen = true;
        }


        tbl_id.row.add(
          [
            (++count),
            eleType,
            ele.date,
            message
          ]
        ).draw(false);


      });
      //end for loop

      if (updateLastSeen) {
        setTimeout(function() {
          updateLastSeenNoti(response.last_id);
        }, (1000 * 10));
      }
    }


    $('#notification-tbl').on('click', '.message-btn', function() {
      let val = $(this).parent('span').siblings("span.message").html();
      $("#noti-message").modal("show");
      $("#noti-message").on('shown.bs.modal', function() {
        $("#noti-message .modal-body p").html(htmlspecialchars_decode(val));
      });
      $("#noti-message").on('hidden.bs.modal', function() {
        $("#noti-message .modal-body p").html('');
      });
    });


    function updateLastSeenNoti(last_id) {
      let data = {
        last_id: last_id,
        _token: $('#hidden_token').val()
      };
      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/notifications/update-last-seen`,
        data: data,
        success: function(res) {

          if (res.code === 200) {
            $('#notification-dropdown').children().find('span.navbar-badge').addClass('d-none');
            getTableInfoData(taskInfoTbl);
          }


        },
        error: function(xhr, status) {
          ajaxErrorCalback(xhr, status);
          isAjax = false;
          $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
          resetLoadingBtn("#frm-submit-btn", btnText);
        }
      });
    }
  </script>
</body>

</html>