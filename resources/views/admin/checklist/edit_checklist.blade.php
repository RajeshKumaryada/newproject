<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Edit Checklist Rule"])
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
              <h1 class="m-0">Edit Checklist Rule</h1>
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
                  <h3 class="card-title">Edit Rule Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="add-user-form">
                  <div class="card-body">

                    <div class="row">
                      @csrf()
                      <input type="hidden" name="checklist_id" value="{{$checklist->checklist_id}}">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Checklist Name (Must be unique)</label>
                          <input type="text" value="{{$checklist->checklist_name}}" name="checklist_name" id="checklist_name" class="form-control">
                        </div>
                      </div>


                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Checklist Text (This will appear at user end)</label>
                          <input type="text" value="{{$checklist->checklist_text}}" name="checklist_text" id="checklist_text" class="form-control">
                        </div>
                      </div>


                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Checklist Type</label>
                          <select class="form-control" name="checklist_type" id="checklist_type" style="width: 100%;">
                            <option value="">--Select--</option>
                            <option value="req" @php echo ($checklist->checklist_type == "req")?"selected":""; @endphp >Required</option>
                            <option value="opt" @php echo ($checklist->checklist_type == "opt")?"selected":""; @endphp >Optional</option>
                          </select>
                        </div>
                      </div>


                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Select Group</label>
                          <select class="form-control select2bs4" name="checklist_group_id" id="checklist_group_id" style="width: 100%;">
                            <option value="">--Select--</option>
                            @foreach($checklistGroup as $row)
                            <option value="{{$row->checklist_group_id}}" @php echo ($checklist->checklist_group_id == $row->checklist_group_id)?"selected":""; @endphp >{{$row->group_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>


                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status" id="status" style="width: 100%;">
                            <option value="">--Select--</option>
                            <option value="1" @php echo ($checklist->status == 1)?"selected":""; @endphp >Active</option>
                            <option value="2" @php echo ($checklist->status == 2)?"selected":""; @endphp >Inactive</option>
                          </select>
                        </div>
                      </div>


                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Update</button>
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
                  <h3 class="card-title">Groups List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Checklist Name</th>
                        <th>Checklist Type</th>
                        <th>Assigned Group</th>
                        <th>Status</th>
                        <th>Checklist Text</th>
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
      getSiteList(dataTbl);
    });

    function getSiteList(dataTbl) {
      dataTbl.clear().draw();
      let url = `{{url('')}}/ajax/admin/checklist/rule/fetch-list`;
      getAjaxData(dataTbl, url, setTableData);
    }


    function setTableData(tbl_id, response) {

      let count = 0;
      let menuEle = null;



      //for loop
      response.data.forEach((ele, idx) => {

        let teamMembers = '';
        let status = '';
        let checklistType = '';

        menuEle = `<div class="text-center">
            <span class="user-badge text-primary"><i data-id="${ele.checklist_id}" class="fas fa-edit cur-ptr edit-group"></i></span>
            <span class="user-badge text-danger"><i data-id="${ele.checklist_id}" class="fas fa-trash cur-ptr delete-group"></i></span>
          </div>`;

        // ele.group_users.forEach(row => {
        //   teamMembers += `<span class="badge badge-success user-badge" title="Team Member">${row.username.username}</span>`;
        // });

        if (ele.status === 1) {
          status = `<span class="user-badge badge-primary">ACTIVE</span>`;
        } else if (ele.status === 2) {
          status = `<span class="user-badge badge-secondary">INACTIVE</span>`;
        }

        if (ele.checklist_type === 'req') {
          checklistType = `<span class="user-badge badge-primary">REQUIRED</span>`;
        } else if (ele.checklist_type === 'opt') {
          checklistType = `<span class="user-badge badge-secondary">OPTIONAL</span>`;
        }

        tbl_id.row.add(
          [
            (++count),
            menuEle,
            ele.checklist_name,
            checklistType,
            `<a href="{{url('')}}/admin/checklist/users-group/${ele.checklist_group.checklist_group_id}/edit" target="_blank">${ele.checklist_group.group_name}</>`,
            status,
            ele.checklist_text
          ]
        ).draw(false);

      });
      //end for loop
    }

    let isAjax = false;
    let frmEle = "#add-user-form";

    $(frmEle).on('submit', function(e) {
      e.preventDefault();
      let formEle = frmEle;
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

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/checklist/rule/save/edit`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              getSiteList(dataTbl);

              // $(frmEle).trigger("reset");
              // $(".select2bs4").val(null).trigger('change');
            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          }
        });
      }

    });

    $('#data-tbl').on('click', '.delete-group', function() {

      if (!confirm('Are you sure to delete?')) {
        return false;
      }

      let checklistId = $(this).attr('data-id');

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/admin/checklist/rule/delete`,
        data: {
          checklist_id: checklistId,
          _token: $('#csrf_token_ajax').val()
        },
        success: function(res) {

          if (res.code === 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });

            getSiteList(dataTbl);
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

    });



    /**
     * Edit team info
     */
    $('#data-tbl').on('click', '.edit-group', function() {
      if (!confirm('Are you sure to edit?')) {
        return false;
      }

      let checklist_id = $(this).attr('data-id');

      window.open(`{{url('')}}/admin/checklist/rule/${checklist_id}/edit`, '_self');
    });
  </script>

</body>

</html>