<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.template.head', ["title"=>"Manage Feedback"])
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
                            <h1 class="m-0">Manage Feedback</h1>
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
                                            <h3 class="card-title">Feedback / Complain</h3>
                                        </div>
                                        <div class="col-md-4 text-right">

                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="user-feedback-tbl" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Employee</th>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Detail</th>
                                                <th>Files</th>
                                                <th>Reply</th>
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
        <div class="modal fade" id="modal-detail">
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
        <div class="modal fade" id="modal-action-reply">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="add-reply">


                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="feed_id" id="feed_id">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Reply</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">

                                        <!-- <div col-md-12>
                                        <h4 class="card-title">Admin</h4>
                                        </div>
                                        <div class="col-md-12">
                                        <p class="card-text text-justify">Some example text. Some example text Some example text. Some example text Some example text. Some example text Some example text. Some example text Some example text. Some example text .</p>
                                        </div>
                                        <div class="col-md-12">
                                        <p href="#" class="">2021-10-05 16:33:07</p>
                                        </div>
                                        -->




                                    </div>

                                    <div>


                                    </div>

                                </div>
                                <div class="form-group p-2">
                                    <textarea class="form-control" rows="3" name="reply" id="reply" placeholder="Enter Your Message"></textarea>
                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- /.content-wrapper -->




    </div>
    <!-- ./wrapper -->
    @include('admin.template.footer')
    @include('admin.template.scripts')
    <script>
        // let isAjax = false;
        // let frmEle = "#feedback-form";

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
        //             url: `{{url('')}}/users/feedback/add-form`,
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
        //                     gettaskAssignList();

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

        $('#user-feedback-tbl').on('click', '#action', function() {

            var id = $(this).attr('data-id');
            var feed = $(this).attr('data-feed');

            // var status = $(this).attr('data-status');

            // var newstat = '';
            // if (status == 3) {
            //     newstat = 'In Process..';
            // }

            // if (newstat) {
            //     $('#modal-action-reply #start-status').html(newstat);
            //     $('#modal-action-reply #start-status').attr('disabled', 'true');
            // } else {
            //     $('#modal-action-reply #start-status').html('start');
            //     $('#modal-action-reply #start-status').removeAttr('disabled', 'true');

            // }

            $.ajax({
                // type: 'POST',
                url: `{{url('')}}/admin/manage/users/feedback/fetch-modal-data`,
                // data: new FormData(this),
                // contentType: false,
                // processData: false,
                data: {
                    id: id,
                    feed: feed,
                },
                success: function(res) {

                    if (res.code === 200) {
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: res.msg
                        // });

                        var index = '';
                        var ele = '';



                        $.each(res.data, function(index, ele) {
                            // index is your 0-based array index
                            // el is your value
                            // for example
                            //    alert("element at " + index + ": " + el.reply); // will alert each value
                            // alert(feed);
                            if (ele.source == 'user') {
                                var datanew = `<div class="col-md-12">
                                        <h4 class="card-title float-right">${ele.users.username}</h4>
                                        </div>
                                        <div class="col-md-12">
                                        <p class="card-text float-right text-justify">${ele.reply}</p>
                                        </div>
                                        <div class="col-md-12">
                                        <p href="#" class="float-right">${ele.created_at}</p>
                                        </div>`;
                                $('#modal-action-reply .modal-body .row').append(datanew);
                            } else {

                                var dataadmin = `<div class="col-md-12"> 
                                        <h4 class="card-title">Admin</h4>
                                        </div>
                                        <div class="col-md-12">
                                        <p class="card-text text-justify">${ele.reply}</p>
                                        </div>
                                        <div class="col-md-12">
                                        <p href="#" class="">${ele.created_at}</p>
                                        </div>`;
                                $('#modal-action-reply .modal-body .row').append(dataadmin);
                            }


                            // console.log(data);




                        });
                        $('#modal-action-reply #feed_id').val(feed);
                        $('#modal-action-reply #id').val(id);
                        $('#modal-action-reply').modal('show');

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

            $('#modal-action-reply').on('hide.bs.modal', function() {
                $('#modal-action-reply .modal-body .row').html(' ');
            });




        });

        var taskInfoTbl;
        var modelTable;

        var Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        $(function() {


            $("#user-feedback-tbl").DataTable({
                columnDefs: [{
                    bSortable: false,
                    targets: [1]
                }],
                "paging": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#user-feedback-tbl_wrapper .col-md-6:eq(0)');

            taskInfoTbl = $("#user-feedback-tbl").DataTable();

            gettaskAssignList();



        });


        function gettaskAssignList() {
            taskInfoTbl.clear().draw();
            let url = `{{url('')}}/admin/manage/users/feedback/fetch-feedback`;
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

                let status = '';

                if (ele.status == 0) {
                    status = `<button class="btn btn-danger btn-xs" disabled>close</button>`;
                } else {
                    status = `<button class="btn btn-success btn-xs" id="status" data-id="${ele.id}" data-action="0">open</button>`;
                }

                let reply ='';

                if(ele.status == 0){
                    reply = `<button class="btn btn-danger btn-xs" id="action" data-id="${ele.id}" data-feed="${ele.feed_id}" data-reply="${ele.reply}" disabled>Action</button>`;
                }else{
                    reply = `<button class="btn btn-danger btn-xs" id="action" data-id="${ele.id}" data-feed="${ele.feed_id}" data-reply="${ele.reply}">Action</button>`;
                }
                
                const d = new Date(`${ele.date}`);
                const dn = d.toLocaleString();
               
                tbl_id.row.add(

                    [
                        (++count),
                        ele.users.username,
                        dn,
                        ele.sub,
                        `<button class="btn btn-info btn-xs" id="detail" data-id="${ele.id}" data-detail="${ele.detail}">Detail</button>`,
                        `<a href="{{url('')}}/admin/manage/users/feedback/images/${ele.id}" target="_blank">View Files</a>`,
                        reply,
                        status,
                    ]
                ).draw(false);

            });
            //end for loop
        }

        $('#user-feedback-tbl').on('click', '#detail', function() {
            $id = $(this).val();
            var detail = $(this).attr('data-detail');
            //  alert(des);
            $('#modal-detail .modal-body').html(detail);
            $('#modal-detail').modal('show');

        });

        $('#user-feedback-tbl').on('click', '#status', function() {

            if(!confirm('Are you sure, You want to deactivate this request:')){
                return false;
            }

            var id = $(this).attr('data-id');
            var status = $(this).attr('data-action');
            // alert(id);
            //  alert(des);
            // $('#modal-detail .modal-body').html(detail);
            // $('#modal-detail').modal('show');

            $.ajax({
                type: 'POST',
                url: `{{url('')}}/admin/manage/users/feedback/add-status`,
                data: {
                    id: id,
                    status: status,
                    _token:`{{csrf_token()}}`
                },

                success: function(res) {

                    if (res.code === 200) {
                        Toast.fire({
                            icon: 'success',
                            title: res.msg
                        });

                        gettaskAssignList();

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


        $('#add-reply').on('submit', function(e) {
            e.preventDefault();
            // alert('sssss');
            $.ajax({
                type: 'POST',
                url: `{{url('')}}/admin/manage/users/feedback/add-reply`,
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(res) {

                    if (res.code === 200) {
                        Toast.fire({
                            icon: 'success',
                            title: res.msg
                        });

                        $('#modal-action-reply .modal-body .row').append(`
                        <div class="col-md-12"> 
                                        <h4 class="card-title">Admin</h4>
                                        </div>
                                        <div class="col-md-12">
                                        <p class="card-text text-justify">${res.data.reply}</p>
                                        </div>
                                        <div class="col-md-12">
                                        <p href="#" class="">${res.data.created_at}</p>
                                        </div>
                        `);

                        $('#reply').val(' ');
                        // $('#start-status').removeAttr('disabled');
                        // $('#start-status').text('Start');
                        // $('#status-remark')[0].reset();
                        // $('#modal-action-remark').modal('hide');
                        // window.location.reload();



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

        $('#modal-action-reply').on('hide.bs.modal', function() {
            // console.log('hide');
            $('#modal-action-reply .modal-body .row').html(' ');
        });
    </script>

</body>

</html>