<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Add SEO Task"])
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
              <h1 class="m-0">SEO Task List</h1>
            </div>

          </div>
        </div>
      </div>

      <input type="hidden" id="hidden_token" value="{{csrf_token()}}">


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">SEO Task</h3>
                  <span class="float-right">
                    <button class="btn btn-default btn-sm addTask">Add SEO Task</button>
                  </span>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

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
                  <h3 class="card-title">[<span id="tot-emps"></span>] Users List</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Task Name</th>
                        <th>Is Exclude from URL Check?</th>
                    <tbody></tbody>
                    </tr>
                    </thead>
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

    <div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Task</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <form id="formSeoTask">
            <!-- Modal body -->
            <div class="modal-body">
              @csrf
              <div class="form-group">
                <label>Task Name</label>
                <input type="text" name="task" id="task" class="form-control" value="" placeholder="Enter Task">
              </div>

              <div class="form-group">
                <label>Is Exclude from URL Check?</label>
                <select class="form-control" name="exclude_from_url_check" id="exclude_from_url_check">
                  <option value="">--Select--</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>



            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-danger" id="loader">Add SEO Task</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="myModalupdate">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Task</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form id="formSeoTaskUpdate">
          <!-- Modal body -->
          <div class="modal-body">
            @csrf
            <input type="hidden" name="update_id" id="update_id">
            <div class="form-group">
              <label>Task Name</label>
              <input type="text" name="update_task" id="update_task" class="form-control" value="" placeholder="Enter Task">
            </div>

            <div class="form-group">
              <label>Is Exclude from URL Check?</label>
              <select class="form-control" name="update_exclude_from_url_check" id="update_exclude_from_url_check">
                <option value="">--Select--</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>



          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-danger" id="loader">Update SEO Task</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <!-- ./wrapper -->

  @include('admin.template.scripts')
  <script>
    var dataTableObj;

    $(function() {
      $("#data-table").DataTable({
        columnDefs: [{
          bSortable: false,
          targets: [1]
        }],
        "paging": true,
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

      dataTableObj = $("#data-table").DataTable();
      getDepList();
    });

    function getDepList() {
      dataTableObj.clear().draw();
      let url = `{{url('')}}/ajax/admin/manage/seo-task-list/list`;
      getAjaxData(dataTableObj, url, setTableData);
    }

    function setTableData(tbl_id, response) {

      let count = 0;
      //for loop
      response.data.forEach((ele, idx) => {

        // let editButton = `<button class="btn btn-sm btn-danger edit-url" value="${ele.id}" data-taskname="${ele.task}"  data-taskurl="${ele.exclude_from_url_check}">
        //         Edit
        //       </button>`;

        let menu = `<div>
                      <button class="btn btn-sm btn-link text-primary edit-url" value="${ele.id}" data-taskname="${ele.task}"  data-taskurl="${ele.exclude_from_url_check}">
                           <i class="fas fa-edit"></i>
                          </button>
                          
                          <button class="btn btn-sm btn-link text-danger delete-url" value="${ele.id}">
                        <i class="fas fa-trash"></i>
                      </button>
                      </div>`;

        let statusShow = '';

        if (ele.exclude_from_url_check == 1) {
          statusShow = '<span class="text-success">Yes</span>';
        } else if (ele.exclude_from_url_check == 0) {
          statusShow = '<span class="text-danger">No</span>';
        }

        tbl_id.row.add(
          [
            (++count),
            menu,
            ele.task,
            statusShow,

          ]
        ).draw(false);
      });

      //end for loop

      document.getElementById('tot-emps').innerHTML = count;
    }

    var isAjax = false;

    let Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });

    $('.addTask').on('click', function() {
      $('#myModal').modal('show');
    });

    $("#formSeoTask").on("submit", function(e) {
      e.preventDefault();


      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      var load = $('#loader');
      var btnTextload = $(load).html();

      $.ajax({
        url: `{{url('')}}/ajax/admin/manage/seo-task-list/add-new-task`,
        type: 'post',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
          activeLoadingBtn(load);
          $('#loader').attr('disabled', 'disabled');

        },
        success: function(res) {

          resetLoadingBtn(load, btnTextload);

          $('#loader').removeAttr('disabled');

          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });
            $('#formSeoTask').trigger('reset');
            getDepList();
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



    $('#data-table').on('click', '.edit-url', function() {
      var id = $(this).val();
      var taskName = $(this).attr("data-taskname");
      var taskUrl = $(this).attr("data-taskurl");
      var token = $('#hidden_token').val();

      $('#update_id').val(id);
      $('#update_task').val(taskName);
      $('#update_exclude_from_url_check').val(taskUrl);
      $("#myModalupdate").modal("show");

    });


    $("#formSeoTaskUpdate").on("submit", function(e) {
      e.preventDefault();


      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      var loadnew = $('#loader');
      var btnTextloadnew = $(loadnew).html();

      $.ajax({
        url: `{{url('')}}/ajax/admin/manage/seo-task-list/update`,
        type: 'post',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
          activeLoadingBtn(loadnew);
          $('#loader').attr('disabled', 'disabled');

        },
        success: function(res) {

          resetLoadingBtn(loadnew, btnTextloadnew);

          $('#loader').removeAttr('disabled');

          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });
            $('#formSeoTaskUpdate').trigger('reset');
            $("#myModalupdate").modal("hide");
            getDepList();
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
    $('#data-table').on('click', '.delete-url', function() {

      if (!confirm('Are you sure you want to Delete')) {
        return;
      }

      var id = $(this).val();
      var token = $('#hidden_token').val();

      $.ajax({
        url: "{{url('')}}/ajax/admin/manage/seo-task-list/delete",
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
            getDepList(dataTableObj);
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