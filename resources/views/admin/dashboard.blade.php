<!DOCTYPE html>
<html lang="en">

<head>

  @include('admin.template.head', ['title'=>'Dashboard'])
  <style>
    .dishfw tbody tr td:nth-child(9),
    .tdhf {
      display: none;
    }
  </style>
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
              <h1 class="m-0">Dashboard</h1>
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
              <div class="small-box bg-info">
                <div class="inner">
                  <h3 id="active-emps"></h3>
                  <p>Active Employees</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
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
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3 id="tot-emps"></h3>
                  <p>Registred Employees</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{url('')}}/admin/user/manage" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3 id="crr-sales">0</h3>
                  <p>Sales on {{date('F, Y')}}</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{url('')}}/admin/order/dashboard" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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

                    <div class="col-md-6">
                      <h3 class="card-title">Active Employees / Interns - <strong>{{date('Y-m-d')}}</strong></h3>
                    </div>
                    <div class="col-md-3">
                      <a href="{{url('admin')}}/dashboard/filter-by-date" class="btn btn-outline-danger">
                        <i class="far fa-calendar-alt"></i> Filter Attendance by Date
                      </a>
                    </div>
                    <div class="col-md-3 text-right">
                      <button class="btn btn-outline-danger" id="refresh-tbl-data">
                        <i class="fas fa-sync-alt"></i> Refresh
                      </button>
                    </div>

                  </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="active-users-tbl" class="table table-bordered table-striped dishfw">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Emp Name</th>
                        <th>Gender</th>
                        <th>Designation</th>
                        <th>Alert Alarm</th>
                        <th>Location</th>
                        <th>Working Task</th>
                        <th class="tdhf">Start Task Time</th>
                        <th>Login Time</th>
                        <th>End Time</th>
                        <!-- <th>Active Duration</th> -->
                        <th>Total Duration</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Emp Name</th>
                        <th>Gender</th>
                        <th>Designation</th>
                        <th>Alert Alarm</th>
                        <th>Location</th>
                        <th>Working Task</th>
                        <th class="tdhf">Start Task Time</th>
                        <th>Login Time</th>
                        <!-- <th>Active Duration</th> -->
                        <th>End Time</th>
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

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  @include('admin.template.scripts')

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
      let url = `{{url('')}}/ajax/admin/working-users`;
      getAjaxData(activeUserTbl, url, setTableData);

      setInterval(function() {
        // activeUserTbl.clear().draw();
        getAjaxData(activeUserTbl, url, setTableData);
      }, (1000 * 60 * 5));


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

      // let activeList = Array();
      let inactiveList = Array();

      //for loop
      response.data.forEach((ele, idx) => {

        let gender = '';
        let menu = `<div class="text-center">
                      <a title="Login as User" href="{{url('')}}/admin/login-as-user/${ele.user_id}/login" target="_blank" class="user-badge text-danger"><i class="fas fa-door-open"></i></a>
                    </div>`;

        switch (ele.gender) {
          case 'm':
            gender = `<span class="badge badge-success user-badge">Male</span>`;
            break;

          case 'f':
            gender = `<span class="badge badge-danger user-badge">Female</span>`;
            break;

          case 'o':
            gender = `<span class="badge badge-warning user-badge">Other</span>`;
            break;
        }

        let alarm_status = '';

        if (ele.alarm_status == null) {
          alarm_status = `<span class="badge badge-danger user-badge"><i class="far fa-bell-slash"></i></span>`;
        } else if (ele.alarm_status == 2) {
          alarm_status = `<span class="badge badge-danger user-badge"><i class="far fa-bell-slash"></i></span>`;
        } else if (ele.alarm_status == 1) {
          alarm_status = `<span class="badge badge-success user-badge"><i class="fa fa-check" aria-hidden="true"></i>
</span>`;
        }

        let login_loc = '';

        if (ele.login_loc == null) {
          login_loc = '';
        } else if (ele.login_loc == 2) {
          login_loc = `<span class="badge badge-info user-badge">Home</span>`;
        } else if (ele.login_loc == 1) {
          login_loc = `<span class="badge badge-primary user-badge">Office</span>`;
        }

        let end_time = '';

        if (ele.end_time == null) {
          end_time = '';
        }else{
          end_time = '';
        }

        let start_time_f = '';

        if (ele.start_time_first == null) {
          start_time_f = '';
        } else {
          start_time_f = `${ele.start_time_first}`;
        }


        if (ele.is_task_active) {
          actEmp++;

          tbl_id.row.add(
            [
              (++count),
              menu,
              ele.username,
              gender,
              ele.designation,
              alarm_status,
              login_loc,
              ele.task,
              ele.start_time,
              start_time_f,
              end_time,
              // calculateWorkDuration(ele.start_time, workingDurationFormat),
              `<span class="font-weight-bold">${ele.total_working_hours}</span>`,
              `<span class="badge badge-success user-badge">ACTIVE</span>`
            ]
          ).draw(false);
        } else {

          inactiveList.push({
            // (++count),
            menu: menu,
            username: ele.username,
            gender: gender,
            designation: ele.designation,
            alarm_status: alarm_status,
            login_loc: login_loc,
            task: "-",
            start_time: ele.start_time,
            start_time_first: ele.start_time_first,
            end_time: `${ele.end_time}`,
            wr_hr: `<span class="font-weight-bold">${ele.total_working_hours}</span>`,
            status: `<span class="badge badge-secondary user-badge">NOT ACTIVE</span>`

          });

        }





      });
      //end for loop

      inactiveList.forEach((ele, idx) => {
        tbl_id.row.add(
          [
            (++count),
            ele.menu,
            ele.username,
            ele.gender,
            ele.designation,
            ele.alarm_status,
            ele.login_loc,
            ele.task,
            ele.start_time,
            ele.start_time_first,
            ele.end_time,
            ele.wr_hr,
            ele.status,

          ]
        ).draw(false);
      });

      document.getElementById('active-emps').innerHTML = actEmp;
      document.getElementById('working-emps').innerHTML = count;
      document.getElementById('tot-emps').innerHTML = response.user_count;
    }


    function getCurrentMonthSales() {
      let isAjax = false;
      let sales = 0;
      if (!isAjax) {

        isAjax = true;


        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/order/dashboard/get/crr-month-total-sale`,
          data: {
            _token: $('#csrf_token_ajax').val()
          },
          // contentType: json,
          // processData: true,
          success: function(res) {

            if (res.code === 200) {

              if (res.data.length > 0) {
                sales = res.data[0].total_order;
              }

              $('#crr-sales').html(sales);

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
          }
        });
      }
    }

    getCurrentMonthSales();
  </script>
</body>

</html>