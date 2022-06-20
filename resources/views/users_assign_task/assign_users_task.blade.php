<!DOCTYPE html>
<html lang="en">

<head>
    @include('user_template.head', ["title"=>"User Assign Task"])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        @include('user_template.nav')


        @include('user_template.aside')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">User Assign Task</h1>
                        </div>
                    </div>
                </div>
            </div>



            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3 class="card-title"></h3>
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
                                                <th>Date</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Files</th>
                                                <th>Action</th>
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



        <!-- The Modal -->
        <div class="modal fade" id="modal-description">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
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
        <div class="modal fade" id="modal-action-remark">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="status-remark">


                        @csrf
                        <input type="hidden" name="id" id="id">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Task Status</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="comment">Remark:</label>
                                <textarea class="form-control" rows="5" name="remark" id="remark"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="comment">Attach Files:</label>
                                <input type="file" class="form-control" name="files[]" id="files" multiple>
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">

                        <button type="button" class="btn btn-primary" id="start-status" data-status="3">start</button>
                          

                            <button type="submit" class="btn btn-primary" id="end-status" data-status="2">Submit Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- /.content-wrapper -->

        @include('user_template.footer')


    </div>
    <!-- ./wrapper -->

    @include('user_template.scripts')
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
            let url = `{{url('')}}/users/assign-task/fetch`;
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

                // let image = '';


                // ele.images.forEach((user) => {
                //     image += `<span class='badge badge-primary user-badge'>${images.images}</span>`
                // });

                // let status = '';

                // if (ele.status == 0) {
                //     status = '<span class="badge badge-primary">Not Seen</span>';
                // } else if ((ele.status == 1)) {
                //     status = '<span class="badge badge-info">Seen</span>';
                // } else {
                //     status = '<span class="badge badge-success">Completed</span>';
                // }



                tbl_id.row.add(
                    [
                        (++count),
                        ele.created_at,
                        ele.title,
                        `<button class="btn btn-info btn-xs" id="description" value="${ele.id}" data-des="${ele.des}">Description</button>`,
                        `<a href="{{url('')}}/users/assign-task/user/images/${ele.id}" target="_blank">View Files</a>`,
                        `<button class="btn btn-danger btn-xs" id="action" data-id="${ele.id}" data-status="${ele.status}">Action</button>`,
                    ]
                ).draw(false);

            });
            //end for loop
        }

        $('#task-assign-tbl').on('click', '#description', function() {
            $id = $(this).val();
            var des = $(this).attr('data-des');
            //  alert(des);
            $('#modal-description .modal-body').html(des);
            $('#modal-description').modal('show');

        });


        $('#start-status').on('click', function() {
            var id = $('#id').val();
            var status = $(this).attr('data-status');
            var _token = `{{csrf_token()}}`;
            //   alert(id);
            $.ajax({
                type: 'POST',
                url: `{{url('')}}/users/assign-task/user/status-progress`,
                data: {
                    id: id,
                    status: status,
                    _token: _token
                },
                // contentType: false,
                // processData: false,
                success: function(res) {

                    if (res.code === 200) {
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: res.msg
                        // });

                        $('#start-status').attr('disabled', 'true');
                        $('#start-status').text('In Process...');
                        // $(".select2bs4").val(null).trigger('change');

                    } else if (res.code === 100) {
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

        //  var id =  $('#id').val();
        // var remark = $('#remark').val();

        // // var status = $(this).attr('data-status');
        // var _token = `{{csrf_token()}}`;
        //   alert(id);

        $('#status-remark').on('submit', function(e) {
            e.preventDefault();
            // alert('sssss');
            $.ajax({
                type: 'POST',
                url: `{{url('')}}/users/assign-task/user/submit-remark`,
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(res) {

                    if (res.code === 200) {
                        Toast.fire({
                            icon: 'success',
                            title: res.msg
                        });

                        $('#start-status').removeAttr('disabled');
                        $('#start-status').text('Start');
                        $('#status-remark')[0].reset();
                        $('#modal-action-remark').modal('hide');
                        window.location.reload();

                        // $(".select2bs4").val(null).trigger('change');

                    } else if (res.code === 100) {
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

        $('#task-assign-tbl').on('click', '#action', function() {

            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');

            var newstat = '';
            if(status == 3){
                newstat = 'In Process..';
            }

            if(newstat){
                $('#modal-action-remark #start-status').html(newstat);
                $('#modal-action-remark #start-status').attr('disabled','true');
            }else{
                $('#modal-action-remark #start-status').html('start');
                $('#modal-action-remark #start-status').removeAttr('disabled','true');
               
            }
            
            
            $('#modal-action-remark #id').val(id);
            $('#modal-action-remark').modal('show');

        });





        // let isAjax = false;
        // let frmEle = "#add-user-form";

        // $(frmEle).on('submit', function(e) {
        //     e.preventDefault();
        //     let formEle = frmEle;
        //     if (!isAjax) {
        //         isAjax = true;

        //         $('#frm-submit-btn').attr('disabled', 'true');
        //         let btnText = $('#frm-submit-btn').html();
        //         activeLoadingBtn("#frm-submit-btn");

        //         var Toast = Swal.mixin({
        //             toast: true,
        //             position: 'center',
        //             showConfirmButton: false,
        //             timer: 3000
        //         });



        //         $.ajax({
        //             type: 'POST',
        //             url: `{{url('')}}/admin/manage/users/assign-task/add`,
        //             data: new FormData(this),
        //             contentType: false,
        //             processData: false,
        //             success: function(res) {

        //                 if (res.code === 200) {
        //                     Toast.fire({
        //                         icon: 'success',
        //                         title: res.msg
        //                     });

        //                     $(frmEle).trigger("reset");
        //                     $(".select2bs4").val(null).trigger('change');

        //                 } else if (res.code === 100) {
        //                     showInvalidFields(res.err);
        //                 } else {
        //                     Toast.fire({
        //                         icon: 'error',
        //                         title: res.msg
        //                     });
        //                 }

        //                 isAjax = false;
        //                 $('#frm-submit-btn').removeAttr('disabled');
        //                 resetLoadingBtn("#frm-submit-btn", btnText);
        //             },
        //             error: function(xhr, status, err) {
        //                 ajaxErrorCalback(xhr, status, err);

        //                 isAjax = false;
        //                 $('#frm-submit-btn').removeAttr('disabled');
        //                 resetLoadingBtn("#frm-submit-btn", btnText);
        //             }
        //         });
        //     }

        // });
    </script>

</body>

</html>