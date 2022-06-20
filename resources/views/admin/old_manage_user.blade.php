<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Manage User"])
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
              <h1 class="m-0">Manage User</h1>
            </div>

          </div>
        </div>
      </div>

      <input type="hidden" id="hidden_token" value="{{csrf_token()}}">

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">[<span id="tot-emps"></span>] Users List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="all-users-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Post</th>
                        <th>Designation</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Post</th>
                        <th>Designation</th>
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
    $(function() {
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


      taskInfoTbl = $("#all-users-tbl").DataTable();
      let url = `{{url('')}}/ajax/admin/user/all-list`;
      getAjaxData(taskInfoTbl, url, setTableData);

      $('#all-users-tbl').on('click', '.emp-status', function() {
        if (confirm('Are you sure to change?')) {
          // let ele = $(this);
          // let val = $(this).val();
          changeEmpStatus(this);
        }
      });
    });

    function setTableData(tbl_id, response) {

      let count = 0;

      //for loop
      response.data.forEach((ele, idx) => {

        let menuEle = `<div class="btn-group text-center">
            <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-bars"></i> &nbsp;
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" href="./manage/edit/${ele.user_id}">Edit</a>
              <a class="dropdown-item" href="./manage/edit/${ele.user_id}/user-info">User Info</a>
              <a class="dropdown-item" href="./manage/edit/${ele.user_id}/bank-info">Bank Info</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" title="Login as User" href="{{url('')}}/admin/login-as-user/${ele.user_id}/login" target="_blank">Login as User</a>
            </div>
          </div>`;

        let eleiCheck = null;
        if (ele.status === 1) {
          eleiCheck = `<button class="btn btn-sm btn-success emp-status" value="${ele.user_id}" id="status-check-${ele.user_id}">
                        Activated
                      </button>`;
        } else {
          eleiCheck = `<button class="btn btn-sm btn-secondary emp-status" value="${ele.user_id}" id="status-check-${ele.user_id}">
                        Deactivated
                      </button>`;
        }

        tbl_id.row.add(
          [
            (++count),
            menuEle,
            ele.username,
            ele.email,
            ele.department.dep_name,
            ele.post.post_name,
            ele.designation.des_name,
            eleiCheck,
          ]
        ).draw(false);

      });
      //end for loop

      document.getElementById('tot-emps').innerHTML = count;
    }

    var isAjax = false;

    function changeEmpStatus(ele) {

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

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/user/update-status`,
          data: {
            id: $(ele).val(),
            _token: $('#hidden_token').val()
          },
          success: function(res) {

            // let data = JSON.parse(res);
            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              $(ele).removeClass(res.btn.remClass);
              $(ele).addClass(res.btn.addClass);
              resetLoadingBtn(ele, res.btn.text);

            } else if (res.code === 100) {
              Toast.fire({
                icon: 'error',
                title: res.err
              });

              resetLoadingBtn(ele, btnText);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

              resetLoadingBtn(ele, btnText);
            }

            isAjax = false;
            $(ele).removeAttr('disabled');
          },
          error: function() {
            alert("did not work");
            isAjax = false;
            $(ele).removeAttr('disabled');
            resetLoadingBtn(ele, btnText);
          }
        });
      }

    }
  </script>

</body>

</html>