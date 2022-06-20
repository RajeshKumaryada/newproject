<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Notification List"])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    @include('admin.template.nav')


    @include('admin.template.aside')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-md-12">
              <h1 class="m-0">Notification List</h1>
            </div>
          </div>
        </div>
      </div>


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="card-title">List</h3>
                    </div>
                    <div class="col-md-4 text-right">
                      <a href="{{url('')}}/admin/notification/create" class="btn btn-link">Create Notification</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="notification-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Date</th>
                        <th>Employess</th>
                        <th>Message</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
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

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  <div class="modal fade" id="show-users" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">User Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">

            <table id="all-users-tbl" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Department</th>
                  <th>Post</th>
                  <th>Designation</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


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


  <div class="modal fade" id="notify-edit">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Notification</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form id="formNotifyUpdate">
          <!-- Modal body -->
          <div class="modal-body">
            @csrf
            <input type="hidden" name="update_id" id="update_id">

            <div class="form-group">
              <label for="comment">Message:</label>
              <textarea class="form-control" rows="8" name="update_message" id="update_message"></textarea>
            </div>

          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-danger" id="loader">Update</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  @include('admin.template.scripts')

  <script src="{{url('')}}/htmlspecialchars_decode.js"></script>

  <script>
    var taskInfoTbl;
    var modelTable;

    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });

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


      $("#all-users-tbl").DataTable({
        columnDefs: [{
          bSortable: false,
          targets: [1]
        }],
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#all-users-tbl_wrapper .col-md-6:eq(0)');

      taskInfoTbl = $("#notification-tbl").DataTable();

      getNotificationList();


      modelTable = $("#all-users-tbl").DataTable();

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


      $('#notification-tbl').on('click', '.emp-type', function() {
        getEmpNames(this);
        $("#show-users").modal("show");
      });
    });


    function getNotificationList() {
      taskInfoTbl.clear().draw();
      let url = `{{url('')}}/ajax/admin/notification/list`;
      getAjaxData(taskInfoTbl, url, setTableData);
    }


    function setTableData(tbl_id, response) {

      let count = 0;

      //for loop
      response.data.forEach((ele, idx) => {

        let menuEle = `<button class="btn btn-sm btn-link text-primary edit-notify" value="${ele.id}">
                           <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-link text-danger delete-notify" value="${ele.id}">
                        <i class="fas fa-trash"></i>
                      </button>`;

        let message = trimStr(ele.message);

        if (message.length > 80) {
          message = `<span>${message} <button class="btn btn-sm btn-link message-btn">
                        View 
                      </button></span>
                      <span class="message d-none">${n2br(ele.message)}</span>
                      <span class="d-none" id="noti_msg_${ele.id}">${(ele.message)}</span>
                      `;
        } else {
          message = `<span id="noti_msg_${ele.id}">${message}</span>`;
        }



        let eleType = null;
        if (ele.type === 'all') {
          eleType = `<button class="btn btn-sm btn-secondary">
                        All
                      </button>`;
        } else {
          eleType = `<button class="btn btn-sm btn-success emp-type" value="${ele.id}">
                        Some
                      </button>`;
        }

        tbl_id.row.add(
          [
            (++count),
            menuEle,
            ele.date,
            eleType,
            message
          ]
        ).draw(false);

      });
      //end for loop
    }

    var isAjax = false;

    function getEmpNames(ele) {
      if (!isAjax) {
        isAjax = true;
        $(ele).attr('disabled', 'true');
        let btnText = $(ele).html();
        activeLoadingBtn(ele);

        let Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        modelTable.clear().draw();

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/notification/list/emp-names`,
          data: {
            id: $(ele).val(),
            _token: $('#csrf_token_ajax').val()
          },
          success: function(res) {

            if (res.code === 200) {


              setUserTableData(modelTable, res);

            } else if (res.code === 100) {
              Toast.fire({
                icon: 'error',
                title: res.err
              });

            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }

            isAjax = false;
            resetLoadingBtn(ele, btnText);
            $(ele).removeAttr('disabled');
          },
          error: function(xhr, stats) {
            Toast.fire({
              icon: 'error',
              title: stats
            });
            console.log(xhr);
            isAjax = false;
            $(ele).removeAttr('disabled');
            resetLoadingBtn(ele, btnText);
          }
        });
      }


    }


    function setUserTableData(tbl_id, response) {

      let count = 0;

      //for loop
      response.data.forEach((ele, idx) => {


        tbl_id.row.add(
          [
            (++count),
            ele.users.username,
            ele.users.email,
            ele.users.department.dep_name,
            ele.users.post.post_name,
            ele.users.designation.des_name,
          ]
        ).draw(false);




      });
      //end for loop


    }


    $('#notification-tbl').on('click', '.edit-notify', function() {
      var id = $(this).val();
      var message = $(`#noti_msg_${id}`).html();
      var token = $('#csrf_token_ajax').val();

      $('#update_id').val(id);
      $('#update_message').val(htmlspecialchars_decode(message));
      $("#notify-edit").modal("show");
    });


    //update
    $("#formNotifyUpdate").on("submit", function(e) {
      e.preventDefault();

      $.ajax({
        url: "{{url('')}}/ajax/admin/notification/update",
        type: 'post',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(res) {
          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });
            $("#notify-edit").modal("hide");
            getNotificationList();
          } else if (res.code == 100) {
            showInvalidFields(res.err);
          } else {
            Toast.fire({
              icon: 'error',
              title: res.msg
            });
          }
        }
      });
    });


    // Delete
    $('#notification-tbl').on('click', '.delete-notify', function() {

      if (!confirm('Are you sure you want to Delete')) {
        return;
      }

      var id = $(this).val();
      var token = $('#csrf_token_ajax').val();

      $.ajax({
        url: "{{url('')}}/ajax/admin/notification/delete",
        type: 'post',
        data: {
          id: id,
          _token: token
        },
        // contentType: false,
        // processData: false,
        success: function(res) {
          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });
            getNotificationList();
          } else {
            Toast.fire({
              icon: 'error',
              title: res.msg
            });
          }
        }
      });
    });
  </script>

</body>

</html>