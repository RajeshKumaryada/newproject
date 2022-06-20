<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.template.head', ["title"=>"Admin Assign Task"])
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
                            <h1 class="m-0">Add Assign Tasks</h1>
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

                                <form id="add-user-form" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="row">


                                            <div class="col-md-6">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="form-group">
                                                    <label>Select Employee</label>
                                                    <select class="form-control select2bs4" name="user_list[]" id="user_list" style="width: 100%;">
                                                        @foreach($users as $user)

                                                        <option value="{{$user->user_id}}">{{$user->username}} - {{$user->post()->first()->post_name}}</option>


                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Enter Title</label>
                                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title..." value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Enter Description</label>
                                                    <textarea type="text" class="form-control" name="des" id="des" row="8" value="" placeholder="Enter Description..."></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Attach File</label>
                                                    <input type="file" class="form-control" name="files[]" id="files" multiple>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status" id="status" style="width: 100%;">

                                                        <option value="1">Active</option>
                                                        <option value="0">Deactive</option>

                                                    </select>
                                                </div>
                                            </div> -->
                                        </div>

                                    </div>

                                    <div class="card-footer">

                                        <div class="float-left">
                                            <!-- <a href="{{url('')}}/" class="btn btn-link">Back to List</a> -->
                                        </div>

                                        <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Assign</button>
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
                                    <table id="task-assign-tbl" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Employee</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Remark</th>
                                                <th>Files</th>
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

    <!-- The Modal -->
    <div class="modal fade" id="modal-des">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Description</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="modal-remark">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Remark</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    @include('admin.template.scripts')
    <script>
        var taskInfoTbl;
        var modelTable;

        var Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        $(function() {


            $("#task-assign-tbl").DataTable({
                columnDefs: [{
                    bSortable: false,
                    targets: [1]
                }],
                "paging": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#task-assign-tbl_wrapper .col-md-6:eq(0)');


            taskInfoTbl = $("#task-assign-tbl").DataTable();

            gettaskAssignList();



        });


        function gettaskAssignList() {
            taskInfoTbl.clear().draw();
            let url = `{{url('')}}/ajax/admin/manage/users/assign-task/fetch`;
            getAjaxData(taskInfoTbl, url, setTableData);
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

                if (ele.status == 0) {
                    status = '<span class="badge badge-primary">Not Seen</span>';
                } else if ((ele.status == 1)) {
                    status = '<span class="badge badge-info">Seen</span>';
                } else if (ele.status == 2) {
                    status = '<span class="badge badge-success">Completed</span>';
                } else {
                    status = '<span class="badge badge-danger">In Process</span>';
                }

                let des = `<button class="btn btn-sm btn-info btn-xs" id="btn-des" value="${ele.id}" data-des="${ele.des}">
                         Description
                       </button>`;

                let remark = `<button class="btn btn-sm btn-info btn-xs" id="btn-remark" value="${ele.id}" data-remark="${ele.remark}">
                         Remark
                       </button>`;




                tbl_id.row.add(
                    [
                        (++count),
                        users,
                        ele.title,
                        des,
                        status,
                        remark,
                        `<a href="{{url('')}}/admin/manage/users/assign-task/${ele.user_id}/images/${ele.id}" target="_blank">View Files</a>`
                    ]
                ).draw(false);

            });
            //end for loop
        }


        $('#task-assign-tbl').on('click', '#btn-des', function() {

            $id = $(this).val();
            $des = $(this).attr('data-des');

            $('#modal-des .modal-body').html($des);
            $('#modal-des').modal('show');

        });

        $('#task-assign-tbl').on('click', '#btn-remark', function() {

            $id = $(this).val();
            $remark = $(this).attr('data-remark');

            $('#modal-remark .modal-body').html($remark);
            $('#modal-remark').modal('show');

        });





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
                    url: `{{url('')}}/admin/manage/users/assign-task/add`,
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
                            gettaskAssignList();

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