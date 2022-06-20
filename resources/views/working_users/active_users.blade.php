<!DOCTYPE html>
<html lang="en">

<head>

  @include('user_template.head', ['title'=>'Dashboard'])

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
              <h1 class="m-0">Working Employees / Interns</h1>
            </div>

          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->


      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3 id="working-emps"></h3>
                  <p>Today Working Employees</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->

          </div>
          <!-- /.row -->

        </div><!-- /.container-fluid -->
      </section>


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">

                  <div class="row">

                    <div class="col-8">
                      <h3 class="card-title">Working Employees / Interns</h3>
                    </div>
                    <div class="col-4 text-right">
                      <button class="btn btn-link" id="refresh-tbl-data">
                        <i class="fas fa-sync-alt"></i> Refresh
                      </button>
                    </div>

                  </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="active-users-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Emp Name</th>
                        <th>Designation</th>
                        <th>Working Task</th>
                        <th>Start Time</th>
                        <th>Active Duration</th>
                        <th>Total Duration</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Emp Name</th>
                        <th>Designation</th>
                        <th>Working Task</th>
                        <th>Start Time</th>
                        <th>Active Duration</th>
                        <th>Total Duration</th>
                        <th>Status</th>
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

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->

  @include('user_template.scripts')

  <script>
    var activeUserTbl;

    $(function() {
      $("#active-users-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#active-users-tbl_wrapper .col-md-6:eq(0)');


      activeUserTbl = $("#active-users-tbl").DataTable();
      let url = `{{url('')}}/ajax/active-users`;
      getAjaxData(activeUserTbl, url, setTableData);

      // setInterval(function() {
      //   activeUserTbl.clear().draw();
      //   getAjaxData(activeUserTbl, url, setTableData);
      // }, (1000 * 60 * 5));

      let isAjax = false;
      $('#refresh-tbl-data').on('click', function(e) {

        if (!isAjax) {
          isAjax = true;

          $(this).attr('disabled', 'true');
          let btnText = $(this).html();
          activeLoadingBtn("#refresh-tbl-data");

          $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {

              if (response.code === 200) {
                setTableData(activeUserTbl, response);
              }

              isAjax = false;
              $('#refresh-tbl-data').removeAttr('disabled');
              resetLoadingBtn('#refresh-tbl-data', btnText);
            },
            error: function(xhr, status) {
              ajaxErrorCalback(xhr, status)
              isAjax = false;
              $('#refresh-tbl-data').removeAttr('disabled');
              resetLoadingBtn('#refresh-tbl-data', btnText);
            }
          });

        }

      });

    });

    function setTableData(tbl_id, response) {
      tbl_id.clear().draw();
      let count = 0;
      let actEmp = 0;


      //for loop
      response.data.forEach((ele, idx) => {


        if (ele.is_task_active) {
          actEmp++;
          tbl_id.row.add(
            [
              (++count),
              ele.username,
              ele.designation,
              ele.task,
              ele.start_time,
              calculateWorkDuration(ele.start_time, workingDurationFormat),
              `<span class="font-weight-bold">${ele.total_working_hours}</span>`,
              `<span class="btn btn-sm btn-success">ACTIVE</span>`
            ]
          ).draw(false);
        }

        // else {
        //   tbl_id.row.add(
        //     [
        //       (++count),
        //       ele.username,
        //       ele.designation,
        //       "-",
        //       "-",
        //       "-",
        //       `<span class="font-weight-bold">${ele.total_working_hours}</span>`,
        //       `<span class="btn btn-sm btn-secondary">NOT ACTIVE</span>`
        //     ]
        //   ).draw(false);
        // }



      });
      //end for loop

      // document.getElementById('active-emps').innerHTML = actEmp;
      document.getElementById('working-emps').innerHTML = actEmp;
    }
  </script>
</body>

</html>