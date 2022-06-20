<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ['title'=>'All User Attendance by Date'])
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
              <h1 class="m-0">All User Attendance by Date</h1>
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
                  <h3 class="card-title">Day Wise Report</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <div class="card-body">

                  <div class="row">

                    <div class="col-12">
                      <form id="form-att-report-by-date" method="post">
                        @csrf()
                        <div class="row">


                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Filter Date</label>
                              <input type="date" name="filter_date" id="filter_date" value="{{date('Y-m-d')}}" class="form-control" placeholder="Select Month">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="w-100">&nbsp;</label>
                              <button type="submit" id="frm-submit-btn" class="btn btn-primary">Show Records by date</button>
                            </div>
                          </div>
                        </div>
                      </form>
                      <hr>
                    </div>


                    <div class="col-12">

                      <div class="row">

                        <div class="col-12">

                          <table id="data-table" class="table table-sm table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>Working Time</th>
                                <th>Is Worked</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
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
    var activeUserTbl;

    $(function() {
      $("#data-table").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

      activeUserTbl = $("#data-table").DataTable();


    });

    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });



    function setTableData(tbl_id, response) {
      tbl_id.clear().draw();
      let count = 0;
      let actEmp = 0;

      // let activeList = Array();
      let inactiveList = Array();

      //for loop
      response.data.forEach((ele, idx) => {

        let status = '';


        if (ele.is_worked === 'yes') {
          actEmp++;

          status = `<span class="badge badge-success user-badge">Yes</span>`;

          tbl_id.row.add(
            [
              (++count),
              ele.username,
              ele.designation,
              ele.total_working_hours,
              status
            ]
          ).draw(false);
        } else {

          status = `<span class="badge badge-danger user-badge">NO</span>`;

          inactiveList.push({
            // (++count),
            username: ele.username,
            designation: ele.designation,
            total_working_hours: ele.total_working_hours,
            status: status
          });

        }

      });
      //end for loop

      inactiveList.forEach((ele, idx) => {
        tbl_id.row.add(
          [
            (++count),
            ele.username,
            ele.designation,
            ele.total_working_hours,
            ele.status
          ]
        ).draw(false);
      });

    }




    $("#form-att-report-by-date").on("submit", function(e) {
      e.preventDefault();

      $.ajax({
        url: "{{url('')}}/ajax/admin/dashboard/filter-by-date",
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

            setTableData(activeUserTbl, res);
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
  </script>
</body>

</html>