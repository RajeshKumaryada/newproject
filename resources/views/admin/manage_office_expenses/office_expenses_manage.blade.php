<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.template.head', ["title"=>"Manage Office Expenses"])
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
                                <!-- form start -->
                                <form id="formExpenses">
                                    @csrf
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <input type="date" value="{{date('Y-m-d')}}" name="date" id="date" class="form-control">
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
                                                <div class="form-group">
                                                    <label>Particular</label>
                                                    <textarea name="particular" id="particular" rows="5" class="form-control" placeholder="Enter Particular"></textarea>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control select2bs4" name="type" id="type" style="width: 100%;">
                                                        <option value="">--Select--</option>
                                                        <option value="1">Deposit</option>
                                                        <option value="2">Expense</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input type="text" name="amount" id="amount" class="form-control" value="" placeholder="Enter Amount">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" id="loader" class="btn btn-primary float-right">Add</button>
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


        </div>
        <!-- /.content-wrapper -->
        @include('admin.template.footer')
    </div>


    <!-- ./wrapper -->

    @include('admin.template.scripts')

    <script>
        // Add Designation data
        let Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });
        var load = $('#loader');
        var btnTextload = $(load).html();


        $("#formExpenses").on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{url('')}}/ajax/admin/manage/office-expenses/add-form-data",
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
                        
                        $('#formExpenses #particular').val('');
                        $('#formExpenses #amount').val('');

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