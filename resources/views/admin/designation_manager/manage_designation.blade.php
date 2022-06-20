<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Manage Designations"])
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
              <h1 class="m-0">Manage Designations</h1>
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
                  <h3 class="card-title">Total Designations Found [<span id="tot-emps"></span>]</h3>
                  <span class="float-right">
                    <button class="btn btn-primary btn-sm addDesignation">Add Designation</button>
                  </span>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Designation Name</th>
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
  </div>

  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Designation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form id="formDesignation">
          <!-- Modal body -->
          <div class="modal-body">
            @csrf
           
            <div class="form-group">
              <label for="name">Designation Name :</label>
              <input type="name" class="form-control" name="des_name" id="des_name">
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-danger" id="loader">Submit</button>
          </div>        
        </form>

      </div>
    </div>
  </div>

  <div class="modal fade" id="myModaledit">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Designation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="formDesignationedit">
          <!-- Modal body -->
          <div class="modal-body">
            @csrf
            <input type="hidden" name="update_des_id" id="update_des_id">
            <div class="form-group">
              <label for="name">Designation Name :</label>
              <input type="name" class="form-control" name="update_des_name" id="update_des_name">
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-danger" id="loader">Submit</button>
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
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');
     
      dataTableObj = $("#data-table").DataTable();
      getDepList();
    });

    function getDepList() {
      dataTableObj.clear().draw();
      let url = `{{url('')}}/ajax/admin/designation/list`;
      getAjaxData(dataTableObj, url, setTableData);
    }

    function setTableData(tbl_id, response) {

      let count = 0;
      //for loop
      response.data.forEach((ele, idx) => {

        // let editButton = `<button class="btn btn-sm btn-danger edit-des" value="${ele.des_id}" data-desname="${ele.des_name}">
        //                 Edit
        //               </button>`;
        let menu = `<div>
                      <button class="btn btn-sm btn-link text-primary edit-des" value="${ele.des_id}" data-desname="${ele.des_name}">
                           <i class="fas fa-edit"></i>
                          </button>
                          
                          <button class="btn btn-sm btn-link text-danger delete-des" value="${ele.des_id}" data-desname="${ele.des_name}">
                        <i class="fas fa-trash"></i>
                      </button>
                      </div>`;

        tbl_id.row.add(
          [
            (++count),
            menu,
            ele.des_name,
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

    var load = $('#loader');
    var btnTextload = $(load).html();

    // Add Designation modal Form

    $('.addDesignation').on('click', function() {
      $('#myModal').modal('show');
    });

    // Add Designation data

    $("#formDesignation").on("submit", function(e) {
      e.preventDefault();

      $.ajax({
        url: "{{url('')}}/ajax/admin/designation/add",
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
            $('#formDesignation').trigger('reset');
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

    // Get name By edit Button

    $('#data-table').on('click', '.edit-des', function() {
      var id = $(this).val();
      var desName = $(this).attr("data-desname");
      var token = $('#hidden_token').val();

      $('#update_des_id').val(id);
      $('#update_des_name').val(desName);
      $("#myModaledit").modal("show");
    });

    // Update Designation

    $("#formDesignationedit").on("submit", function(e) {
      e.preventDefault();

      $.ajax({
        url: "{{url('')}}/ajax/admin/designation/update",
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
            $("#myModaledit").modal("hide");
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

    $('#data-table').on('click', '.delete-des', function() {
    
    if(!confirm('Are you sure you want to Delete')){
      return;
    }

    var id = $(this).val();
    var token = $('#hidden_token').val();
    
    $.ajax({
      url: "{{url('')}}/ajax/admin/designation/delete",
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