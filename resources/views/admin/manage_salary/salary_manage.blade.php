<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Add Salary Details"])
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
              <h1 class="m-0">Add Salary Details</h1>
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
                  <h3 class="card-title">Salary of User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <form id="formSalary">
                  @csrf
                  <div class="card-body">

                    <div class="row">

                      <input type="hidden" name="user_id" value="{{ $userId }}">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Salary</label>
                          <input type="text" name="salary" id="salary" class="form-control" placeholder="Enter Salary">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Joining date</label>
                          <input type="date" name="created_at" id="created_at" class="form-control">
                        </div>
                      </div>

                      <!--
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Last date</label>
                      <input type="date" name="last_date" id="last_date" class="form-control" value="" placeholder="Enter Message">
                    </div>
                  </div>

                   <div class="col-sm-4">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status" id="status">
                            <option value="1">Active</option>
                            <option value="2">Not Active</option>
                          </select>
                        </div>
                      </div> -->

                    </div>

                  </div>


                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Add Salary</button>
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
      <input type="hidden" id="hidden_token" value="{{csrf_token()}}">

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Total Salary Found[<span id="tot-emps"></span>]</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Salary</th>
                        <th>Entry Date</th>
                        <th>Last Date</th>
                        <th>Status</th>
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
  </div>



  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="myModaledit">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Salary</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">

              <form id="formSalaryUpdate">
                @csrf

                <input type="hidden" name="update_user_id" value="{{ $userId }}">
                <input type="hidden" name="update_id" id="update_id">

                <div class="form-group">
                  <label>Enter Salary</label>
                  <input type="text" name="update_salary" id="update_salary" class="form-control">
                </div>

                <div class="form-group">
                  <label>Enter Joining date</label>
                  <input type="date" name="update_created_at" id="update_created_at" class="form-control">
                </div>

                <div class="form-group">
                  <label>Last date</label>
                  <input type="date" name="update_last_date" id="update_last_date" class="form-control">
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="update_status" id="update_status">
                    <option value="1">Active</option>
                    <option value="0">Not Active</option>
                  </select>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" id="loader" class="btn btn-primary float-right">Update Salary</button>
                </div>

              </form>
            </div>
          </div>
        </div>



      </div>
    </div>
  </div>
  @include('admin.template.footer')


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
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

      dataTableObj = $("#data-table").DataTable();
      getDepList();
    });

    function getDepList() {
      dataTableObj.clear().draw();
      let url = `{{url('')}}/ajax/admin/manage/salary/list/{{$userId}}`;
      getAjaxData(dataTableObj, url, setTableData);
    }

    function setTableData(tbl_id, response) {

      let count = 0;
      //for loop
      response.data.forEach((ele, idx) => {

        // let editButton = `<button class="btn btn-sm btn-danger edit-dep" value="${ele.dep_id}" data-depname="${ele.dep_name}">
        //             Edit
        //           </button>`;

        let menu = `<div>
                      <button class="btn btn-sm btn-link text-primary edit-salary" value="${ele.id}" data-salary="${ele.salary}" data-createdat="${ele.created_at}" data-lastdate="${ele.last_date}" data-status="${ele.status}">
                           <i class="fas fa-edit"></i>
                          </button>
                          
                          <button class="btn btn-sm btn-link text-danger delete-salary" value="${ele.id}">
                        <i class="fas fa-trash"></i>
                      </button>
                      </div>`;


        tbl_id.row.add(
          [
            (++count),
            menu,
            ele.salary,
            ele.created_at,
            ele.last_date,
            ele.status
          ]
        ).draw(false);
      });

      //end for loop

      document.getElementById('tot-emps').innerHTML = count;
    }

    let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

    $("#formSalary").on("submit", function(e) {
      e.preventDefault();


      var load = $('#loader');
      var btnTextload = $(load).html();

      $.ajax({
        url: `{{url('')}}/ajax/admin/manage/salary/add-new`,
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
            $('#formSite').trigger('reset');
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

    /**
     * Edit Salary
     */
    $('#data-table').on('click', '.edit-salary', function() {
      var id = $(this).val();
      var salary = $(this).attr("data-salary");
      var createdAt = $(this).attr("data-createdat");
      var lastDate = $(this).attr("data-lastdate");
      var siteStatus = $(this).attr("data-status");
      var token = $('#hidden_token').val();

      $('#update_id').val(id);
      $('#update_salary').val(salary);
      $('#update_created_at').val(createdAt);
      $('#update_last_date').val(lastDate);
      $('#update_status').val(siteStatus);
      $("#myModaledit").modal("show");
    });


    /** 
     * Update Salary
     */
    $("#formSalaryUpdate").on("submit", function(e) {
      e.preventDefault();

      var loadnew = $('#loader');
      var btnTextloadnew = $(loadnew).html();

      $.ajax({
        url: `{{url('')}}/ajax/admin/manage/salary/update`,
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
            $('#formSalaryUpdate').trigger('reset');
            $('#myModaledit').modal('hide');
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
    /**
     * Delete Salary
     */
    $('#data-table').on('click', '.delete-salary', function() {
    
    if(!confirm('Are you sure you want to Delete')){
      return;
    }

    var id = $(this).val();
    var token = $('#hidden_token').val();
    
    $.ajax({
      url: "{{url('')}}/ajax/admin/manage/salary/delete",
      type: 'post',
      data: {id:id,_token:token},
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