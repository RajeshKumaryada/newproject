<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.template.head', ["title"=>"Manage Sites"])
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
                            <h1 class="m-0">Manage Website</h1>
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
                                    <h3 class="card-title">Total Sites Found[<span id="tot-emps"></span>]</h3>
                                    <span class="float-right">
                                        <button class="btn btn-primary btn-sm addSite">Add Site Info</button>
                                    </span>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="data-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Menu</th>
                                                <th>Site Name</th>
                                                <th>Site Url</th>
                                                <th>Site Catagory</th>
                                                <th>Status</th>
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
                    <h4 class="modal-title">Add Site Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form id="formSite">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <label for="name">Site Name :</label>
                            <input type="text" class="form-control" name="site_name" id="site_name">
                        </div>

                        <div class="form-group">
                            <label for="name">Site Url :</label>
                            <input type="text" class="form-control" name="site_url" id="site_url">
                        </div>

                        <div class="form-group">
                            <label for="sel1">Site Catagory:</label>
                            <select class="form-control" id="site_category" name="site_category">
                                <option name="pro" value="pro">Product</option>
                                <option name="info" value="info">Information</option>
                                <option name="ecom" value="ecom">E-commerce</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sel1">Site Status:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="2">Not Active</option>
                            </select>
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
                    <h4 class="modal-title">Edit Site Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formSiteedit">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="update_site_id" id="update_site_id">
                        <div class="form-group">
                            <label for="name">Site Name:</label>
                            <input type="text" class="form-control" name="update_site_name" id="update_site_name">
                        </div>

                        <div class="form-group">
                            <label for="name">Site Url:</label>
                            <input type="text" class="form-control" name="update_site_url" id="update_site_url">
                        </div>

                        <div class="form-group">
                            <label for="sel1">Site Catagory:</label>
                            <select class="form-control" id="update_site_category" name="update_site_category">
                                <option value="pro">Product</option>
                                <option value="info">Information</option>
                                <option value="ecom">E-commerce</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sel1">Site Status:</label>
                            <select class="form-control" id="update_status" name="update_status">
                                <option value="1">Active</option>
                                <option value="2">Not Active</option>
                            </select>
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
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

            dataTableObj = $("#data-table").DataTable();
            getDepList();
        });

        function getDepList() {
            dataTableObj.clear().draw();
            let url = `{{url('')}}/ajax/admin/site-info/list`;
            getAjaxData(dataTableObj, url, setTableData);
        }

        function setTableData(tbl_id, response) {

            let count = 0;
            //for loop
            response.data.forEach((ele, idx) => {


                let menu = `<div>
                      <button class="btn btn-sm btn-link text-primary edit-site" value="${ele.id}" data-sitename="${ele.site_name}" data-siteurl="${ele.site_url}" data-sitecategory="${ele.site_category}" data-status="${ele.status}">
                           <i class="fas fa-edit"></i>
                          </button>
                          
                          <button class="btn btn-sm btn-link text-danger delete-site" value="${ele.id}">
                        <i class="fas fa-trash"></i>
                      </button>
                      </div>`;

                let statusShow = '';

                if (ele.status == 1) {
                    statusShow = '<span class="text-success">Active</span>';
                } else if (ele.status == 2) {
                    statusShow = '<span class="text-danger">Not Active</span>';
                }

                let siteCatagory = '';

                if (ele.site_category == 'pro') {
                    siteCatagory = "Product";
                } else if (ele.site_category == 'info') {
                    siteCatagory = "Information";
                } else if (ele.site_category == 'ecom') {
                    siteCatagory = "E-Commerce";
                }


                tbl_id.row.add(
                    [
                        (++count),
                        menu,
                        ele.site_name,
                        ele.site_url,
                        siteCatagory,
                        statusShow,

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

        // Add Site modal Form

        $('.addSite').on('click', function() {
            $('#myModal').modal('show');
        });

        // Add Site data

        $("#formSite").on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{url('')}}/ajax/admin/site-info/add",
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

        // Get name By edit Button

        $('#data-table').on('click', '.edit-site', function() {
            var id = $(this).val();
            var siteName = $(this).attr("data-sitename");
            var siteUrl = $(this).attr("data-siteurl");
            var siteCategory = $(this).attr("data-sitecategory");
            var siteStatus = $(this).attr("data-status");
            var token = $('#hidden_token').val();

            $('#update_site_id').val(id);
            $('#update_site_name').val(siteName);
            $('#update_site_url').val(siteUrl);
            $('#update_site_category').val(siteCategory);
            $('#update_status').val(siteStatus);
            $("#myModaledit").modal("show");
        });

        // Update Site

        $("#formSiteedit").on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{url('')}}/ajax/admin/site-info/update",
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

        // Delete
        $('#data-table').on('click', '.delete-site', function() {

            if (!confirm('Are you sure you want to Delete')) {
                return;
            }

            var id = $(this).val();
            var token = $('#hidden_token').val();

            $.ajax({
                url: "{{url('')}}/ajax/admin/site-info/delete",
                type: 'post',
                data: {
                    id: id,
                    _token: token
                },
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