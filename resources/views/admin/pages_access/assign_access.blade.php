<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Grant Page Access to User"])
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
              <h1 class="m-0">Grant Page Access to User</h1>
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
                  <h3 class="card-title">Add Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="add-new-form">
                  <div class="card-body">

                    <div class="row">
                      @csrf()

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Enter Page Name</label>
                          <input class="form-control" name="page_name" id="page_name">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Select Users</label>
                          <select class="form-control select2bs4" name="user_id[]" id="user_id" style="width: 100%;" multiple>
                            @foreach($users as $row)
                            <option value="{{$row->user_id}}">{{$row->designation()->first()->des_name}} - {{$row->username}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Enter URL</label>
                          <input class="form-control" name="url" id="url">
                        </div>
                      </div>

                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Grant Access</button>
                  </div>

                </form>


              </div>
              <!-- /.card -->

            </div>
            <!--/.col (left) -->

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
                  <h3 class="card-title">Access List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-tbl" class="table table-sm table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 30px;">#</th>
                        <th style="width: 55px;">Menu</th>
                        <th>Page Name</th>
                        <th>Page URL</th>
                        <th>Users</th>
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

  @include('admin.template.scripts')
  <script>
    var dataTbl;

    $(function() {

      $("#data-tbl").DataTable({
        columnDefs: [{
          bSortable: false,
          targets: [1]
        }],
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#data-tbl_wrapper .col-md-6:eq(0)');

      dataTbl = $("#data-tbl").DataTable();
      getAccessList(dataTbl);


      let isAjax = false;
      let frmEle = "#add-new-form";

      $(frmEle).on('submit', function(e) {
        e.preventDefault();
        let formEle = frmEle;
        if (!isAjax) {
          isAjax = true;

          $('#frm-submit-btn').attr('disabled', 'true');
          let btnText = $('#frm-submit-btn').html();
          activeLoadingBtn("#frm-submit-btn");

          let Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
          });

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/admin/security/manage/pages/grant-access`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {

              if (res.code === 200) {
                getAccessList(dataTbl);
                Toast.fire({
                  icon: 'success',
                  title: res.msg
                });
                $(frmEle).trigger("reset");
                $(".select2bs4").val(null).trigger('change');

              } else if (res.code === 100) {
                showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              $('#frm-submit-btn').removeAttr('disabled');
              resetLoadingBtn("#frm-submit-btn", btnText);
            },
            error: function(xhr, status, err) {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;

              $('#frm-submit-btn').removeAttr('disabled');
              resetLoadingBtn("#frm-submit-btn", btnText);
            }
          });
        }

      });

    });


    /**
     * get list for table 
     */
    function getAccessList(dataTbl) {
      dataTbl.clear().draw();
      let url = `{{url('')}}/ajax/admin/security/manage/pages/grant-access/list`;
      getAjaxData(dataTbl, url, setTableData);
    }

    /**
     * set table data
     */
    function setTableData(tbl_id, response) {

      let count = 0;
      let menuEle = null;



      //for loop
      response.data.forEach((ele, idx) => {

        let teamMembers = '';

        menuEle = `<div class="text-center">
          <span class="user-badge text-danger"><i data-id="${ele.id}" class="fas fa-trash cur-ptr delete-team"></i></span>
        </div>`;

        ele.assignd_users.forEach(row => {
          teamMembers += `<span class="badge badge-success user-badge">${row.user_name.username}
          <span class="border-left pl-2" title="Delete User">
          <i data-id="${row.id}" class="fas fa-trash cur-ptr delete-access-user" style="font-size:12px;"></i>
          </span></span>`;
        });

        tbl_id.row.add(
          [
            (++count),
            menuEle,
            ele.page_name,
            ele.page_url,
            teamMembers
          ]
        ).draw(false);

      });
      //end for loop
    }


    /**
     * delete access rules
     */
    $('#data-tbl').on('click', '.delete-team', function() {

      if (!confirm('Are you sure to delete?')) {
        return false;
      }

      let access_id = $(this).attr('data-id');

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/admin/security/manage/pages/grant-access/delete`,
        data: {
          access_id: access_id,
          _token: $('#csrf_token_ajax').val()
        },
        success: function(res) {

          if (res.code === 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });

            getAccessList(dataTbl);
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

    });


    /**
     * delete access users
     */
    $('#data-tbl').on('click', '.delete-access-user', function() {

      if (!confirm('Are you sure to delete?')) {
        return false;
      }

      let access_user_id = $(this).attr('data-id');

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/admin/security/manage/pages/grant-access/user-delete`,
        data: {
          access_user_id: access_user_id,
          _token: $('#csrf_token_ajax').val()
        },
        success: function(res) {

          if (res.code === 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });

            getAccessList(dataTbl);
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

    });
  </script>

</body>

</html>