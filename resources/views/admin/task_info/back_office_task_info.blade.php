<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Back Office Task Info"])
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
            <div class="col-sm-12">
              <h1 class="m-0">Back Office Task Info</h1>
            </div>

          </div>
        </div>
      </div>


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Back Office Task Info</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">

                  <div class="row">

                    <div class="col-md-12 mb-2">
                      <form id="select-user-form">

                        <div class="row">

                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                          <input type="hidden" name="usertype" value="back-office">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Users</label>
                              <select class="form-control select2bs4" name="username" id="username" style="width: 100%;"></select>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Select Date</label>
                              <input type="date" name="date" id="date" value="{{date('Y-m-d')}}" class="form-control" placeholder="Enter ...">
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label>&nbsp;</label>
                              <button type="submit" id="frm-submit-btn" class="btn btn-success form-control">Get Details</button>
                            </div>
                          </div>

                        </div>
                      </form>

                      <hr>

                    </div>

                    <div class="col-md-12 mb-4">
                      <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 text-right">
                          <strong>Today Working Hours - <span id="tot_working_hours">0h 0m 0s</span> </strong>
                        </div>
                      </div>

                    </div>

                    <div class="col-md-12">
                      <table id="user-task-tbl" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Date</th>
                            <th>Task</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Time</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Work Location</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                          <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Date</th>
                            <th>Task</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Time</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Work Location</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="card-footer"></div>

              </div>
              <!-- /.card -->

            </div>
            <!--/.col (left) -->

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>


    </div>
    <!-- /.content-wrapper -->

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  @include('admin.template.scripts')
  <script>
    var taskInfoTbl;

    $(document).ready(function() {

      $("#user-task-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#user-task-tbl_wrapper .col-md-6:eq(0)');

      let url = `{{url('')}}/ajax/admin/task/users/back-office`;
      getAjaxData('#username', url, appendChildSelect);


      taskInfoTbl = $("#user-task-tbl").DataTable();


    });


    let isAjax = false;
    let frmEle = "#select-user-form";

    $(frmEle).on('submit', function(e) {
      e.preventDefault();

      if (!isAjax) {
        isAjax = true;
        $(this).children('div.card-footer').children('button[type=submit]').attr('disabled', 'true');
        let btnText = $('#frm-submit-btn').html();
        activeLoadingBtn("#frm-submit-btn");

        let Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        taskInfoTbl.clear().draw();

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/task/fetch`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {


              if (res.data.length > 0) {
                setTableData(taskInfoTbl, res);
                // Toast.fire({
                //   icon: 'success',
                //   title: res.msg
                // });

              } else {
                Toast.fire({
                  icon: 'error',
                  title: 'No data found'
                });
              }

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $(frmEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
            $(frmEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          }
        });
      }

    });



    function setTableData(tbl_id, response) {

      //for loop
      response.data.forEach((ele, idx) => {

        let status = ele.status;
        let action = 'Finished';

        if (ele.action !== 'Finished') {
          status = `Active`;

          action = `<form id="form_${idx}">
                  <input type="hidden" name="_token" value="${response.token}">
                  <input type="hidden" name="task_id" value="${ele.task_id}">
                  <button type="submit" class="btn btn-sm btn-danger finish-task-btn">Finish Task</button>
                </form>`;
        }

        tbl_id.row.add(
          [
            (idx + 1),
            action,
            ele.date,
            ele.task,
            ele.start_time,
            ele.end_time,
            ele.total_time,
            status,
            ele.remark,
            `<button onclick='openMap(this)' value='${ele.start}' class='btn btn-sm btn-link'>START</button> <button class='btn btn-sm btn-link' value='${ele.finish}' onclick='openMap(this)'>FINISH</button>`
          ]
        ).draw(false);
      });
      //end for loop

      $("#tot_working_hours").html(response.total_working_hours);

    }

    isAjax = false;

    $('#user-task-tbl').on('click', '.finish-task-btn', function() {

      if (!confirm('Are you sure?')) {
        return false;
      }

      let btnEle = this;

      $(this).parent('form').submit(function(e) {


        e.preventDefault();

        if (!isAjax) {
          isAjax = true;
          $(btnEle).attr('disabled', 'true');
          let btnText = $(btnEle).html();
          activeLoadingBtn(btnEle);

          let Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
          });



          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/admin/task/back-office/finish`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {

              if (res.code === 200) {
                Toast.fire({
                  icon: 'success',
                  title: res.msg
                });

                isAjax = false;
                $("#frm-submit-btn").trigger("click");

              } else if (res.code === 100) {
                showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              $(btnEle).removeAttr('disabled');
              resetLoadingBtn(btnEle, btnText);
            },
            error: function(xhr, status, err) {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;
              $(btnEle).removeAttr('disabled');
              resetLoadingBtn(btnEle, btnText);
            }
          });
        }

      });
    });
  </script>
</body>

</html>