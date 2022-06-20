<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ['title'=>'Single User Attendance'])
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
              <h1 class="m-0">Single User Attendance</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Month Report</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <div class="card-body">

                  <div class="row">

                    <div class="col-12">
                      <form id="form-att-report">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="row">

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Select Employee</label>
                              <select class="form-control select2bs4" name="user" id="user" style="width: 100%;">
                                @foreach($userList as $row)
                                <option value="{{$row->user_id}}">{{$row->username}} - {{$row->designation()->first()->des_name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Select Month</label>
                              <input type="month" name="work_month" id="work_month" value="{{date('Y-m')}}" class="form-control" placeholder="Select Month">
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label>&nbsp;</label>
                              <button type="submit" id="frm-submit-btn" class="btn btn-primary w-100">Show Record</button>
                            </div>
                          </div>
                        </div>
                      </form>
                      <hr>
                    </div>

                    <div class="col-12">

                      <div class="row mb-3">
                        <div class="col-md-8">
                          <h3 id="user-name"></h3>
                        </div>
                        <div class="col-md-4 text-right">
                          <h3 id="month-name"></h3>
                        </div>
                      </div>

                      <div class="row" id='leaves_info'>

                      </div>

                      <div class="row">

                        <div class="col-12">

                          <table id="task-info-tbl" class="table table-sm table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Actual Hours</th>
                                <th>After Minus Hours</th>
                                <th>Start End Hours</th>
                                <th>Remain Hours</th>
                                <th>Attendance</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            </tfoot>
                          </table>

                        </div>
                      </div>


                    </div>

                  </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>

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

  <!-- Page specific script -->
  <script>
    var taskInfoTbl;

    $(function() {
      $("#task-info-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#task-info-tbl_wrapper .col-md-6:eq(0)');


      taskInfoTbl = $("#task-info-tbl").DataTable();


    });



    let isAjax = false;
    let formEle = "#form-att-report";
    let frmBtn = "#frm-submit-btn";

    $(formEle).on('submit', function(e) {
      e.preventDefault();


      if (!isAjax) {
        isAjax = true;
        $(frmBtn).attr('disabled', 'true');
        let btnText = $(frmBtn).html();
        activeLoadingBtn(frmBtn);

        let Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        taskInfoTbl.clear().draw();
        $('#leaves_info').html('');

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/attendance/single-user`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {


              $('#month-name').html(res.month_name);
              $('#user-name').html(res.user_name);

              setTableData(taskInfoTbl, res);

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $(frmBtn).removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          },
          error: function(status, res, err) {
            if (status.status === 419) {
              alert(status.responseJSON.message, status);
            }

            isAjax = false;
            $(frmBtn).removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          }
        });
      }

    });


    function setTableData(tbl_id, response) {

      let leaves_info = `<div class="col-md-2">
                          <div class="form-group">
                            <label>Days in Month</label>
                            <div class="form-control">${response.leaves.days_in_month}</div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Full Days Present</label>
                            <div class="form-control">${response.leaves.present}</div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Half Day Present</label>
                            <div class="form-control">${response.leaves.halfDayPresent}</div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Full Day Leaves</label>
                            <div class="form-control">${response.leaves.fullDayLeaves}</div>
                          </div>
                        </div>                        
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Extra Working Full Days</label>
                            <div class="form-control">${response.leaves.extraWorFullDay}</div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>Extra Working Half Days</label>
                            <div class="form-control">${response.leaves.extraWorHalfDay}</div>
                          </div>
                        </div>`;

      $('#leaves_info').html(leaves_info);

      //for loop
      response.data.forEach((ele, idx) => {


        let wCount = '';

        if (response.post == '1') {
          wCount = ` &nbsp; [ Words Count - ${ele.word_count}]`;
        }


        let attendance = ele.attendance;

        if (attendance === "Sunday") {
          attendance = `<strong class="text-primary">${ele.attendance}</strong>`;
        }


        tbl_id.row.add(
          [
            (idx + 1),
            ele.date,
            ele.day,
            `<strong>${ele.actual_total_work_hours}</strong>`,
            `<strong>${ele.total_work_hours}</strong> ${wCount}`,
            `<strong>${ele.calculated_first_last_hours}</strong>`,
              `<strong>${ele.diff_work_time}</strong>`,
            attendance,
          ]
        ).draw(false);
      });

    }
  </script>
</body>

</html>