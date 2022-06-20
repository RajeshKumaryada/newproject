<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Edit Checklist Users Group"])
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
              <h1 class="m-0">Edit Checklist Users Group</h1>
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
                  <h3 class="card-title">Edit Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="add-user-form">
                  <div class="card-body">

                    <div class="row">

                      <input type="hidden" name="group_id" value="{{$groupInfo->checklist_group_id}}">

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Group Name (Must be unique)</label>
                          <input type="text" value="{{$groupInfo->group_name}}" name="group_name" id="group_name" class="form-control">
                        </div>
                      </div>


                      <div class="col-md-6">
                        @csrf()
                        <div class="form-group">
                          <label>Add More Users</label>
                          <select class="form-control select2bs4" name="user_id[]" id="user_id" style="width: 100%;" multiple>
                            @foreach($users as $row)

                            @php

                            if(in_array($row->user_id, $userIds)):
                            continue;

                            endif

                            @endphp

                            <option value="{{$row->user_id}}">{{$row->username}} - {{$row->designation()->first()->des_name}}</option>
                            @endforeach
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
                  <h3 class="card-title">Group Users List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Member Name</th>
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
      let url = `{{url('')}}/ajax/admin/checklist/users-group/fetch/{{$groupInfo->checklist_group_id}}/users`;
      getAjaxData(dataTbl, url, setTableData);
    }


    function setTableData(tbl_id, response) {

      let count = 0;
      let menuEle = null;



      //for loop
      response.data.forEach((ele, idx) => {

        let teamMembers = '';

        menuEle = `<div class="text-center">
            <span class="user-badge text-danger"><i data-id="${ele.checklist_group_users_id}" class="fas fa-trash cur-ptr delete-group"></i></span>
          </div>`;


        tbl_id.row.add(
          [
            (++count),
            menuEle,
            `<span class="badge badge-success user-badge" title="Team Member">${ele.username.username}</span>`
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
          url: `{{url('')}}/ajax/admin/checklist/users-group/edit/save`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              // getSiteList(dataTbl);
              window.location.reload();

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

      let relationId = $(this).attr('data-id');

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/admin/checklist/users-group/users/delete`,
        data: {
          group_id: relationId,
          _token: $('#csrf_token_ajax').val()
        },
        success: function(res) {

          if (res.code === 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });

            window.location.reload();
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

      let group_id = $(this).attr('data-id');

      window.open(`{{url('')}}/ajax/admin/checklist/users-group/${group_id}/edit`, '_self');
    });
  </script>

</body>

</html>