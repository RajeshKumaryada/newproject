<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.template.head', ["title"=>"Create Alarm"])
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
                            <h1 class="m-0">Add Alarm</h1>
                        </div>
                    </div>
                </div>
            </div>



            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add Form</h3>
                                </div>
                                <!-- /.card-header -->

                                <form id="add-user-form">
                                    <div class="card-body">

                                        <div class="row">


                                            <div class="col-md-12">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="form-group">
                                                    <label>Select Employee</label>
                                                    <select class="form-control select2bs4" name="user_list[]" id="user_list" style="width: 100%;" multiple>

                                                        @foreach($users as $user)

                                                        <option value="{{$user->user_id}}">{{$user->username}} - {{$user->post()->first()->post_name}}</option>


                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Enter Hours</label>
                                                    <input type="number" name="time_in_hr" id="time_in_hr" class="form-control" placeholder="Enter Hour">
                                                </div>

                                                <div class="form-group">
                                                    <label>Enter Minutes</label>
                                                    <input type="number" name="time_in_min" id="time_in_min" class="form-control" placeholder="Enter Minute">
                                                </div>


                                            </div>




                                        </div>

                                    </div>

                                    <div class="card-footer">

                                        <div class="float-left">
                                            <!-- <a href="{{url('')}}/" class="btn btn-link">Back to List</a> -->
                                        </div>

                                        <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Add Alarm</button>


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
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3 class="card-title">List</h3>
                                        </div>
                                        <div class="col-md-4 text-right">

                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="alarm-assign-tbl" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Menu</th>
                                                <th>Employees</th>
                                                <th>Status</th>
                                                <th>Time</th>
                                                <th>Created At</th>
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
        <div class="modal fade" id="myModaledit">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Alarm</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">

              <form id="formAlarmUpdate">
                @csrf

                <input type="hidden" name="update_user_id" id="update_user_id">
                <input type="hidden" name="update_id" id="update_id">

                <div class="form-group">
                  <label>Enter Time in Hour</label>
                  <input type="number" name="update_time_in_hr" id="update_time_in_hr" class="form-control">
                </div>

                <div class="form-group">
                  <label>Enter Time in Minutes</label>
                  <input type="number" name="update_time_in_min" id="update_time_in_min" class="form-control">
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
                  <button type="submit" id="loader" class="btn btn-primary float-right">Update Alarm</button>
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
        var alarmInfoTbl;
        var modelTable;

        var Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        $(function() {


            $("#alarm-assign-tbl").DataTable({
                columnDefs: [{
                    bSortable: false,
                    targets: [1]
                }],
                "paging": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#alarm-assign-tbl_wrapper .col-md-6:eq(0)');


            alarmInfoTbl = $("#alarm-assign-tbl").DataTable();

            getalarmAssignList();



        });


        function getalarmAssignList() {
            alarmInfoTbl.clear().draw();
            let url = `{{url('')}}/ajax/admin/manage/users/alarm/fetch-data`;
            getAjaxData(alarmInfoTbl, url, setTableData);
        }


        function setTableData(tbl_id, response) {

            let count = 0;

            //for loop
            response.data.forEach((ele, idx) => {


                // <button class="btn btn-sm btn-link text-primary edit-notify" id="edit-notify" value="${ele.id}" data-url="${ele.url}" data-user-ids="${ele.user_ids}">
                //            <i class="fas fa-edit"></i>
                //           </button>

                // let menuEle = `<a href="{{url('')}}/admin/manage/pages-access/${ele.id}/" target="_blank">
                //            <i class="fas fa-edit"></i>
                //            </a>
                //           <button class="btn btn-sm btn-link text-danger delete-notify" value="${ele.id}">
                //         <i class="fas fa-trash"></i>
                //       </button>`;

                let users = '';


                ele.usernames.forEach((user) => {
                    users += `<span class='badge badge-primary user-badge'>${user.username}</span>`
                });

                let status = '';

                if (ele.status == 1) {
                    status = `<a class="btn btn-success" id="active" data-status="${ele.status}" data-id="${ele.id}">Active</a>`;
                } else {
                    status = `<a class="btn btn-danger" id="not-active" data-status="${ele.status}" data-id="${ele.id}">Not Active</a>`;
                }

                // let des = `<button class="btn btn-sm btn-info btn-xs" id="btn-des" value="${ele.id}" data-des="${ele.des}">
                //          Description
                //        </button>`;

                // let remark = `<button class="btn btn-sm btn-info btn-xs" id="btn-remark" value="${ele.id}" data-remark="${ele.remark}">
                //          Remark
                //        </button>`;

                let time = ``;

                if (ele.time_in_hr == 0 && ele.time_in_min == 0) {
                    time = `<span class="badge badge-primary">N/A</span>`;
                } else {
                    time = `<span class="badge badge-success">${ele.time_in_hr}hr ${ele.time_in_min}m</span>`;
                }

                var menu = '';

                menu = ` <div>
                <button class="btn btn-sm btn-link text-danger delete-alarm" value="${ele.id}">
                        <i class="fas fa-trash"></i>
                    </button>

                <button class="btn btn-sm btn-link text-primary edit-alarm" value="${ele.id}" data-user_id ="${ele.user_id}" data-time_in_hr="${ele.time_in_hr}"  data-time_in_min="${ele.time_in_min}" data-createdat="${ele.created_at}" data-status="${ele.status}">
                           <i class="fas fa-edit"></i>
                          </button>
                </div>`;

                tbl_id.row.add(
                    [
                        (++count),
                        menu,
                        users,
                        status,
                        time,
                        ele.created_at
                    ]
                ).draw(false);

            });
            //end for loop
        }

        $('#alarm-assign-tbl').on('click', '.edit-alarm', function() {
      var id = $(this).val();
      var user_id = $(this).attr("data-user_id");
      var time_in_hr = $(this).attr("data-time_in_hr");
      var time_in_min = $(this).attr("data-time_in_min");
      var Status = $(this).attr("data-status");
      var token = $('#hidden_token').val();

      $('#update_id').val(id);
      $('#update_user_id').val(user_id);
      $('#update_time_in_hr').val(time_in_hr);
      $('#update_time_in_min').val(time_in_min);
      $('#update_status').val(Status);
      $("#myModaledit").modal("show");
    });

    $("#formAlarmUpdate").on("submit", function(e) {
      e.preventDefault();

      var loadnew = $('#loader');
      var btnTextloadnew = $(loadnew).html();

      $.ajax({
        url: `{{url('')}}/ajax/admin/manage/users/alarm/update`,
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
            $('#formAlarmUpdate').trigger('reset');
            $('#myModaledit').modal('hide');
            getalarmAssignList();
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


        $('#alarm-assign-tbl').on('click', '.delete-alarm', function() {

            if (!confirm('Are you sure you want to Delete')) {
                return;
            }

            var id = $(this).val();
            var _token = "{{csrf_token()}}";

            $.ajax({
                url: "{{url('')}}/ajax/admin/manage/users/alarm/delete-alarm",
                type: 'post',
                data: {
                    id: id,
                    _token: _token
                },
                // contentType: false,
                // processData: false,
                success: function(res) {
                    if (res.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: res.msg
                        });
                        getalarmAssignList();


                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: res.msg
                        });
                    }
                }
            });
        });


        $('#alarm-assign-tbl').on('click', '#active', function(e) {
            e.preventDefault();

            if (!confirm('Are you sure,you want to Deactivate ?')) {
                return false;
            }
            var id = $(this).attr('data-id');
            var status_active = $(this).attr('data-status');
            var _token = "{{csrf_token()}}";
            if (!isAjax) {
                isAjax = true;



                var Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000
                });


                $.ajax({
                    type: 'POST',
                    url: `{{url('')}}/admin/manage/users/alarm/active-status`,
                    data: {
                        id: id,
                        status: status_active,
                        _token: _token
                    },

                    success: function(res) {

                        if (res.code === 200) {
                            Toast.fire({
                                icon: 'success',
                                title: res.msg
                            });
                            getalarmAssignList();
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: res.msg
                            });
                        }

                        isAjax = false;

                    }

                });
            }


        });

        $('#alarm-assign-tbl').on('click', '#not-active', function(e) {
            e.preventDefault();

            if (!confirm('Are you sure,you want to Activate ?')) {
                return false;
            }
            var id = $(this).attr('data-id');
            var status_active = $(this).attr('data-status');
            var _token = "{{csrf_token()}}";
            if (!isAjax) {
                isAjax = true;



                var Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000
                });


                $.ajax({
                    type: 'POST',
                    url: `{{url('')}}/admin/manage/users/alarm/not-active-status`,
                    data: {
                        id: id,
                        status: status_active,
                        _token: _token
                    },

                    success: function(res) {

                        if (res.code === 200) {
                            Toast.fire({
                                icon: 'success',
                                title: res.msg
                            });

                            getalarmAssignList();

                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: res.msg
                            });
                        }

                        isAjax = false;

                    }

                });
            }


        });


        // $('#alarm-assign-tbl').on('click', '#btn-remark', function() {

        //     $id = $(this).val();
        //     $remark = $(this).attr('data-remark');

        //     $('#modal-remark .modal-body').html($remark);
        //     $('#modal-remark').modal('show');

        // });





        let isAjax = false;
        let frmEle = "#add-user-form";

        $(frmEle).on('submit', function(e) {
            e.preventDefault();
            let formEle = frmEle;
            if (!isAjax) {
                isAjax = true;

                $('#frm-submit-btn').attr('disabled', 'true');
                let btnText = $('#frm-submit-btn').html();
                activeLoadingBtn("#frm-submit-btn");

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000
                });



                $.ajax({
                    type: 'POST',
                    url: `{{url('')}}/admin/manage/users/alarm/add-alarm`,
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(res) {

                        if (res.code === 200) {
                            Toast.fire({
                                icon: 'success',
                                title: res.msg
                            });

                            $(frmEle).trigger("reset");
                            $(".select2bs4").val(null).trigger('change');
                            getalarmAssignList();

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
    </script>

</body>

</html>
