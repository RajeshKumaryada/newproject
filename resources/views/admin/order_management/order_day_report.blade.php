<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Order Day Wise Report"])
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
              <h1 class="m-0">Order Day Wise Report</h1>
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
                  <h3 class="card-title">Order Day Wise Report</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">

                  <div class="row">

                    <div class="col-md-12 mb-2">
                      <form id="select-user-form">

                        <div class="row">

                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>User (Optional)</label>
                              <select class="form-control select2bs4" name="user_id" id="user_id" style="width: 100%;">
                                <option value="">--select--</option>
                                @foreach($users as $row)
                                <option value="{{$row->user_id}}">{{$row->username}} - {{$row->designation()->first()->des_name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>


                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Website (Optional)</label>
                              <select class="form-control select2bs4" name="website_id" id="website_id" style="width: 100%;">
                                <option value="">--select--</option>
                                @foreach($websites as $row)
                                <option value="{{$row->id}}">{{$row->site_name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Select Month</label>
                              <input type="month" name="date" id="date" value="{{date('Y-m')}}" class="form-control" placeholder="Enter ...">
                            </div>
                          </div>


                          <div class="col-md-2">
                            <div class="form-group">
                              <label>&nbsp;</label>
                              <button type="submit" id="frm-submit-btn" class="btn btn-success form-control">Get Details</button>
                            </div>
                          </div>

                        </div>
                      </form>

                      <hr>

                    </div>

                    <div class="col-md-12 mb-4">
                      <div class="row">
                        <div class="col-md-8 small">
                          <button class="btn btn-sm btn-link text-danger"><i class="fas fa-plus"></i></button>: More |
                          <button class="btn btn-sm btn-link text-danger"><i class="fas fa-user"></i></button>: By Users |
                          <button class="btn btn-sm btn-link text-danger"><i class="fab fa-internet-explorer"></i></button>: By Site
                        </div>
                        <div class="col-md-4 text-right">
                          <strong>Total Order(s) - <span id="tot_ord">0</span></strong>
                        </div>
                      </div>

                    </div>

                    <div class="col-md-12">
                      <table id="data-tbl" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Menu</th>
                            <th>Order Date</th>
                            <th>No. of Orders</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="card-footer"></div>

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


    <!-- BS Model -->
    <div class="modal fade" id="userSiteInfo" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">User's Site and Orders</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="table-responsive"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

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
          url: `{{url('')}}/ajax/admin/order/report/day-view`,
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
     * getting more details
     */
    $('#data-tbl tbody').on('click', 'button.more-info-details', function() {

      let tr = $(this).parent().closest('tr');
      let row = taskInfoTbl.row(tr);

      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      } else {

        let orderDate = $(this).attr('data-month');

        if (!isAjax) {

          isAjax = true;
          $(this).attr('disabled', 'true');
          let btnText = $(this).html();
          activeLoadingBtn2(this);

          // taskInfoTbl.clear().draw();

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/admin/order/report/day-view/details`,
            data: {
              _token: $('#csrf_token_ajax').val(),
              date: orderDate
            },
            // contentType: false,
            // processData: false,
            success: (res) => {

              if (res.code === 200) {


                if (res.data.length > 0) {
                  setTableDataMore(taskInfoTbl, res, this);
                } else {
                  Toast.fire({
                    icon: 'error',
                    title: 'No data found'
                  });
                }

              } else if (res.code === 100) {
                // showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            },
            error: (xhr, status, err) => {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            }
          });
        }

      }
    });



    /**
     * getting more users wise details
     */
    $('#data-tbl tbody').on('click', 'button.more-info-users', function() {

      let tr = $(this).parent().closest('tr');
      let row = taskInfoTbl.row(tr);

      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      } else {

        let orderDate = $(this).attr('data-month');

        if (!isAjax) {

          isAjax = true;
          $(this).attr('disabled', 'true');
          let btnText = $(this).html();
          activeLoadingBtn2(this);

          // taskInfoTbl.clear().draw();

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/admin/order/report/day-view/details-users`,
            data: {
              _token: $('#csrf_token_ajax').val(),
              date: orderDate
            },
            // contentType: false,
            // processData: false,
            success: (res) => {

              if (res.code === 200) {


                if (res.data.length > 0) {
                  setTableDataUsers(taskInfoTbl, res, this);
                } else {
                  Toast.fire({
                    icon: 'error',
                    title: 'No data found'
                  });
                }

              } else if (res.code === 100) {
                // showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            },
            error: (xhr, status, err) => {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            }
          });
        }

      }
    });



    /**
     * getting more sites wise details
     */
    $('#data-tbl tbody').on('click', 'button.more-info-sites', function() {

      let tr = $(this).parent().closest('tr');
      let row = taskInfoTbl.row(tr);


      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      } else {

        let orderDate = $(this).attr('data-month');

        if (!isAjax) {

          isAjax = true;
          $(this).attr('disabled', 'true');
          let btnText = $(this).html();
          activeLoadingBtn2(this);

          // taskInfoTbl.clear().draw();

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/admin/order/report/day-view/details-sites`,
            data: {
              _token: $('#csrf_token_ajax').val(),
              date: orderDate
            },
            // contentType: false,
            // processData: false,
            success: (res) => {

              if (res.code === 200) {


                if (res.data.length > 0) {
                  setTableDataSites(taskInfoTbl, res, this);
                } else {
                  Toast.fire({
                    icon: 'error',
                    title: 'No data found'
                  });
                }

              } else if (res.code === 100) {
                // showInvalidFields(res.err);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            },
            error: (xhr, status, err) => {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            }
          });
        }

      }
    });



    /**
     * users-sites-info
     */
    $('#data-tbl tbody').on('click', 'button.users-sites-info', function() {

      // let tr = $(this).parent().closest('tr');
      // let row = taskInfoTbl.row(tr);

      let orderDate = $(this).attr('data-month');
      let userId = $(this).attr('data-userid');

      if (!isAjax) {

        isAjax = true;
        $(this).attr('disabled', 'true');
        let btnText = $(this).html();
        activeLoadingBtn2(this);

        // taskInfoTbl.clear().draw();

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/order/report/day-view/details-sites-users`,
          data: {
            _token: $('#csrf_token_ajax').val(),
            date: orderDate,
            userid: userId,
          },
          // contentType: false,
          // processData: false,
          success: (res) => {

            if (res.code === 200) {


              if (res.data.length > 0) {
                setTableDataUsersSitesInfo(res);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: 'No data found'
                });
              }

            } else if (res.code === 100) {
              // showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $(this).removeAttr('disabled');
            resetLoadingBtn(this, btnText);
          },
          error: (xhr, status, err) => {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
            $(this).removeAttr('disabled');
            resetLoadingBtn(this, btnText);
          }
        });
      }

      // }
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

        totalOrder += eval(ele.total_order);

        menu = `<div class="text-center">
            <button class="btn btn-sm btn-link text-danger more-info-details" data-month="${ele.order_date}">
              <i class="fas fa-plus"></i>
            </button>
            <button class="btn btn-sm btn-link text-danger more-info-users" data-month="${ele.order_date}">
              <i class="fas fa-user"></i>
            </button>
            <button class="btn btn-sm btn-link text-danger more-info-sites" data-month="${ele.order_date}">
              <i class="fab fa-internet-explorer"></i>
            </button>
            </div>`;

        let ord_date;
        let total_order;

        if (ele.total_order > 0) {
          ord_date = `<span>${ele.ord_date}</span>`;
          total_order = `<span>${ele.total_order}</span>`;
        } else {
          ord_date = ele.ord_date;
          total_order = ele.total_order;
        }


        tbl_id.row.add(
          [
            (++count),
            menu,
            ord_date,
            total_order
          ]
        ).draw(false);
      });
      //end for loop

      $("#tot_ord").html(totalOrder);

    }


    /**
     * set info for more data
     */
    function setTableDataMore(tbl_id, response, clickEle) {

      let count = 0;

      let eleTbl = `<table cellpadding="0" cellspacing="0" border="0" style="padding:0px;width: 100%;">
          <thead>
            <tr>
              <th>#</th>
              <th>Username</th>
              <th>Site Name</th>
              <th>Order Date</th>
              <th>Total Orders</th>
              <th>Order Numbers</th>
            </tr>
          </thead>
          <tbody>`;

      response.data.forEach((ele, idx) => {

        eleTbl += `<tr>
        <td>${++count}</td>
        <td>${ele.username.username}</td>
        <td>${ele.website_info.site_name}</td>
        <td>${ele.order_date}</td>
        <td>${ele.number_of_order}</td>
        <td>${ele.order_number}</td>`;

      });

      eleTbl += `</tbody></table>`;

      let tr = $(clickEle).parent().closest('tr');
      let row = tbl_id.row(tr);

      // Open this row
      row.child(eleTbl).show();
    }


    /**
     * set info for more data
     */
    function setTableDataUsers(tbl_id, response, clickEle) {

      let count = 0;

      let eleTbl = `<table cellpadding="0" cellspacing="0" border="0" style="padding:0px;width: 100%;">
          <thead>
            <tr>
              <th>#</th>
              <th>Username</th>
              <th>Total Orders</th>
            </tr>
          </thead>
          <tbody>`;


      response.data.forEach((ele, idx) => {

        eleTbl += `<tr>
          <td>${++count}</td>
          <td>${ele.username.username} - <button class="btn btn-sm btn-link users-sites-info" data-month="${$(clickEle).attr('data-month')}" data-userid="${ele.user_id}">Sites</button></td>
          <td>${ele.total_order}</td>`;

      });

      eleTbl += `</tbody></table>`;

      let tr = $(clickEle).parent().closest('tr');
      let row = tbl_id.row(tr);

      // Open this row
      row.child(eleTbl).show();
    }


    /**
     * Set Table Data Users Sites Info
     */
    function setTableDataUsersSitesInfo(response) {
      let count = 0;

      let eleTbl = `<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0" border="0" style="padding:0px;width: 100%;">
          <thead>
            <tr>
              <th>#</th>
              <th>Username</th>
              <th>Site Name</th>
              <th>Order Date</th>
              <th>Total Orders</th>
              <th>Order Numbers</th>
            </tr>
          </thead>
          <tbody>`;

      response.data.forEach((ele, idx) => {

        eleTbl += `<tr>
        <td>${++count}</td>
        <td>${ele.username.username}</td>
        <td>${ele.website_info.site_name}</td>
        <td>${ele.order_date}</td>
        <td>${ele.number_of_order}</td>
        <td>${ele.order_number}</td>`;

      });

      eleTbl += `</tbody></table>`;

      $("#userSiteInfo").modal("show");
      $("#userSiteInfo").on('shown.bs.modal', function() {
        $("#userSiteInfo .modal-body p").html(eleTbl);
      });
      $("#userSiteInfo").on('hidden.bs.modal', function() {
        $("#userSiteInfo .modal-body p").html('');
      });

    }



    /**
     * set info for more data
     */
    function setTableDataSites(tbl_id, response, clickEle) {

      let count = 0;

      let eleTbl = `<table cellpadding="0" cellspacing="0" border="0" style="padding:0px;width: 100%;">
        <thead>
          <tr>
            <th>#</th>
            <th>Site Name</th>
            <th>Total Orders</th>
          </tr>
        </thead>
        <tbody>`;


      response.data.forEach((ele, idx) => {

        eleTbl += `<tr>
          <td>${++count}</td>
          <td>${ele.website_info.site_name}</td>
          <td>${ele.total_order}</td>`;

      });

      eleTbl += `</tbody></table>`;

      let tr = $(clickEle).parent().closest('tr');
      let row = tbl_id.row(tr);

      // Open this row
      row.child(eleTbl).show();
    }


    /**
     * set info for more data
     */
    function setTableDataDate(tbl_id, response, clickEle) {

      let count = 0;

      let eleTbl = `<table cellpadding="0" cellspacing="0" border="0" style="padding:0px;width: 100%;">
        <thead>
          <tr>
            <th>#</th>
            <th>Order Date</th>
            <th>Total Orders</th>
          </tr>
        </thead>
        <tbody>`;


      response.data.forEach((ele, idx) => {

        eleTbl += `<tr>
          <td>${++count}</td>
          <td>${ele.order_date}</td>
          <td>${ele.total_order}</td>`;

      });

      eleTbl += `</tbody></table>`;

      let tr = $(clickEle).parent().closest('tr');
      let row = tbl_id.row(tr);

      // Open this row
      row.child(eleTbl).show();
    }
  </script>

</body>

</html>