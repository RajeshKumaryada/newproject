<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Edit Order Records"])
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
              <h1 class="m-0">Edit Order Records</h1>
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
                  @csrf()
                  <input type="hidden" name="ord_id" value="{{$ordInfo->ord_id}}">
                  <input type="hidden" name="user_id" value="{{$ordInfo->user_id}}">
                  <div class="card-body">

                    <div class="row">


                      <div class="col-md-3">
                        <div class="form-group">
                          <label>User</label>
                          <div class="form-control">{{$ordInfo->username->username}}</div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Select Websites</label>
                          <select class="form-control select2bs4" name="website_id" id="website_id" style="width: 100%;">
                            <option value="">--select--</option>
                            @foreach($websites as $row)

                            @if($row->id === $ordInfo->website_id)
                            <option value="{{$row->id}}" selected>{{$row->site_name}}</option>
                            @else
                            <option value="{{$row->id}}">{{$row->site_name}}</option>
                            @endif

                            @endforeach
                          </select>
                        </div>
                      </div>


                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Order Date</label>
                          <input type="date" name="order_date" id="order_date" value="{{$ordInfo->order_date}}" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Number of Order(s)</label>
                          <input type="number" name="number_of_order" id="number_of_order" value="{{$ordInfo->number_of_order}}" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Order Numbers (Optional)</label>
                          <input type="text" name="order_number" id="order_number" value="{{$ordInfo->order_number}}" class="form-control">
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">

                  <a href="{{url('')}}/admin/order/manage/add" class="btn btn-link">Back to Add Order</a>

                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Update Record</button>
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
    let isAjax = false;
    let frmEle = "#add-user-form";

    //update order 
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
          url: `{{url('')}}/ajax/admin/order/manage/update`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

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

      window.open(`{{url('')}}/admin/order/manage/edit/${editId}`, '_self');
    });
  </script>

</body>

</html>