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
                            <h1 class="m-0">Manage Office Expenses</h1>
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
                                    <h3 class="card-title">Office Expenses</h3>
                                    
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-12 mb-2">
                                            <form id="select-user-form">

                                                <div class="row">

                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Date</label>
                                                            <input type="month" value="{{date('Y-m')}}" name="date" id="date" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <div class="form-group">
                                                            <label>Employee</label>
                                                            <select class="form-control select2bs4" name="user_list[]" id="user_list" style="width: 100%;">
                                                                @foreach($users as $user)

                                                                <option value="{{$user->user_id}}">{{$user->username}} - {{$user->post()->first()->post_name}}</option>


                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12">
                                                        <div class="form-group text-right">
                                                            <label>&nbsp;</label>
                                                            <button type="submit" id="frm-submit-btn" class="btn btn-success">Get Details</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>

                                            <hr>

                                        </div>

                                       

                                        <div class="col-md-12">
                                            <div class="row  mt-0 mb-2">
                                                <div class="col-md-12  text-right bal">
                                                <strong><span id="balance"></span></strong>
                                                </div>
                                            
                                            </div>
                                        
                                            <table id="data-tbl" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Particular</th>
                                                        <th>Deposit</th>
                                                        <th>Expenses</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div id="deposit"></div>  
                                    <div id="expense"></div>
                                    <div id="year"></div>

                                </div>

                            </div>
                            <!-- /.card -->

                        </div>
                        <!--/.col (left) -->

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>

        </div>
        <!-- /.content-wrapper -->
        @include('admin.template.footer')
    </div>


    <!-- ./wrapper -->

    @include('admin.template.scripts')

    <script>
        var taskInfoTbl;

        var Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        $(document).ready(function() {

            $("#data-tbl").DataTable({
                "paging": false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#data-tbl_wrapper .col-md-6:eq(0)');


            taskInfoTbl = $("#data-tbl").DataTable();
        });


        let isAjax = false;
        let frmEle = "#select-user-form";

        /**
         * getting initial record
         */
        $(frmEle).on('submit', function(e) {
            e.preventDefault();

            if (!isAjax) {

                isAjax = true;
                $('#frm-submit-btn').attr('disabled', 'true');
                let btnText = $('#frm-submit-btn').html();
                activeLoadingBtn("#frm-submit-btn");

                taskInfoTbl.clear().draw();

                $.ajax({
                    type: 'POST',
                    url: `{{url('')}}/ajax/admin/manage/office-expenses/fetch-expenses`,
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(res) {

                        if (res.code === 200) {


                            if (res.data.length > 0) {
                                setTableData(taskInfoTbl, res);
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'No data found'
                                });
                            }
                            var textnull = '';
                            $.each(res.datadep, function(key, value) {
                                
                                if(value.dep_total == null){
                                    textnull = `Deposit value is zero`;
                                }
                                $('.card-footer #deposit').html(value.dep_total ? 'Total Monthly Deposits :'+value.dep_total : `Deposit value is zero` );
                            })
                           
                            $.each(res.dataexp, function(key, value) {
                                if(value.exp_total == null){
                                    textnull = `Expence value is zero`;
                                }
                                $('.card-footer #expense').html(value.exp_total ? 'Total Monthly Expenses :' +value.exp_total  :`Expense value is zero`);
                            })

                           
                            // $.each(res.dataexpYear, function(key, value) {
                            //     if(value.exp_all == null){
                            //         textnull = `Expence value is zero`;
                            //     }
                            //     $('.card-footer #year').html(value.exp_all ? 'Overall Monthly Expenses :' +value.exp_all  :`Total Expence value is zero`);
                            // })
                           
                            
                               
                                $('.bal #balance').html(`Total Balance : ${res.total}`);
                            

                           
                           


                            // $('card-footer #expense').html(res.dataexp.exp_total);

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


    


        /**
         * set initial data
         */
        function setTableData(tbl_id, response) {

            let count = 0;
            let totalOrder = 0;
            let menu = '';

            //for loop
            response.data.forEach((ele, idx) => {

                // totalOrder += eval(ele.total_order);



                var deposit = '';

                if (ele.deposit == null) {
                    deposit = '--';
                } else {
                    deposit = `${ele.deposit}`;
                }
                var expense = '';

                if (ele.expense == null) {
                    expense = '--';
                } else {
                    expense = `${ele.expense}`;
                }


                tbl_id.row.add(
                    [
                        (++count),
                        ele.date,
                        ele.particular,
                        deposit,
                        expense
                    ],
                ).draw(false);


            });
            //end for loop

            // $("#tot_ord").html(totalOrder);

        }

        
    </script>
</body>

</html>