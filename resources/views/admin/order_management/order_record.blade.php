<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Add/View Order Records"])
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
              <h1 class="m-0">Add/View Order Records</h1>
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

                <form id="add-user-form">
                  <div class="card-body">

                    <div class="row">


                      <div class="col-md-3">
                        @csrf()
                        <div class="form-group">
                          <label>Select Users</label>
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
                          <label>Select Websites</label>
                          <select class="form-control select2bs4" name="website_id" id="website_id" style="width: 100%;">
                            <option value="">--select--</option>
                            @foreach($websites as $row)
                            <option value="{{$row->id}}">{{$row->site_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>


                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Order Date</label>
                          <input type="date" name="order_date" id="order_date" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Number of Order(s)</label>
                          <input type="number" name="number_of_order" id="number_of_order" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Order Numbers (Optional)</label>
                          <input type="text" name="order_number" id="order_number" class="form-control" placeholder="#0001,#0002">
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Add Record</button>
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
                      <h3 class="card-title">Order List</h3>
                    </div>
                    <div class="col-md-4 text-right">
                      <strong>Total Orders: <span id="total_orders" class="text-danger"></span></strong>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <div class="table-responsive">
                    <table id="data-tbl" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Menu</th>
                          <th>Order Date</th>
                          <th>Total Orders</th>
                          <th>Order Numbers</th>
                          <th>Username</th>
                          <th>Site Name</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
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
      dataTbl = $('#data-tbl').DataTable({
        processing: true,
        serverSide: true,
        ajax: `{{url('')}}/ajax/admin/order/manage/fetch`,
        "order": [
          [2, 'desc'],
        ],
        "drawCallback": function(respnse) {
          $('#total_orders').html(respnse.json.total_order);
        },
        columns: [{
            data: 'ord_id'
          },
          {
            data: 'menu'
          },
          {
            data: 'order_date'
          },
          {
            data: 'number_of_order'
          },
          {
            data: 'order_number'
          },
          {
            data: 'user_id'
          },
          {
            data: 'website_id'
          },
        ],
        columnDefs: [{
          bSortable: false,
          targets: [1]
        }],
        "paging": true,
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
      });


    });



    let isAjax = false;
    let frmEle = "#add-user-form";

    //add order 
    $(frmEle).on('submit', function(e) {
      e.preventDefault();
      let formEle = frmEle;
      if (!isAjax) {
        isAjax = true;
        $('#frm-submit-btn').attr('disabled', 'true');
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
          url: `{{url('')}}/ajax/admin/order/manage/add`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              dataTbl.draw(true);

              $(frmEle).trigger("reset");
              $(".select2bs4").val(null).trigger('change');
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



    // delete order info
    $('#data-tbl').on('click', '.delete-order', function() {

      if (!confirm('Are you sure to delete?')) {
        return false;
      }

      let deleteId = $(this).attr('data-id');

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/admin/order/manage/delete`,
        data: {
          delete_id: deleteId,
          _token: $('#csrf_token_ajax').val()
        },
        success: function(res) {

          if (res.code === 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });

            dataTbl.draw(true);

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
    $('#data-tbl').on('click', '.edit-order', function() {
      if (!confirm('Are you sure to edit?')) {
        return false;
      }

      let editId = $(this).attr('data-id');

      window.open(`{{url('')}}/admin/order/manage/edit/${editId}`, '_blank');
    });
  </script>

</body>

</html>