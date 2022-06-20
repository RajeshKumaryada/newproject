<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Add Bank Info"])
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
              <h1 class="m-0">Add Bank Details</h1>
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
                  <h3 class="card-title">Bank Details of User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->


                @if(empty($userInfo))

                <form id="formBankInfo">
                  @csrf
                  <div class="card-body">

                    <div class="row">

                      <input type="hidden" name="user_id" value="{{ $userId }}">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Bank Name</label>
                          <input type="text" name="bank_name" id="bank_name" class="form-control" value="" placeholder="Enter Message">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Account Number</label>
                          <input type="text" name="acc_no" id="acc_no" class="form-control" value="" placeholder="Enter Message">
                        </div>
                      </div>
   

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter IFSC Code</label>
                          <input type="text" name="ifsc" id="ifsc" class="form-control" value="" placeholder="Enter Message">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status" id="status">
                            <option value="1">Active</option>
                            <option value="2">Not Active</option>
                          </select>
                        </div>
                      </div>

                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Add Bank Info</button>
                  </div>
                </form>


                @else


                <form id="formBankInfoUpdate">
                  @csrf
                  <div class="card-body">

                    <div class="row">
                      <input type="hidden" name="pid" value="{{$userInfo->id}}">
                      <!-- <input type="hidden" name="user_id" value="{{$userId}}"> -->

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Bank Name</label>
                          <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ $userInfo->bank_name }}" placeholder="Enter Message">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Account Number</label>
                          <input type="text" name="acc_no" id="acc_no" class="form-control" value="{{ $userInfo->acc_no }}" placeholder="Enter Message">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter IFSC Code</label>
                          <input type="text" name="ifsc" id="ifsc" class="form-control" value="{{ $userInfo->ifsc }}" placeholder="Enter Message">
                        </div>
                      </div>
                    </div>

                    <div class="row">



                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status" id="status">
                            <option value="1" @php echo(($userInfo->status=== 1)?'selected':''); @endphp >Active</option>
                            <option value="2" @php echo(($userInfo->status=== 2)?'selected':''); @endphp>Not Active</option>
                          </select>
                        </div>
                      </div>

                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Update Bank Info</button>
                  </div>
                </form>

                @endif




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
    $("#formBankInfo").on("submit", function(e) {
      e.preventDefault();


      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      var load = $('#loader');
      var btnTextload = $(load).html();

      $.ajax({
        url: `{{url('')}}/admin/manage/options/bank-info/add-new-bank-info`,
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

    $("#formBankInfoUpdate").on("submit", function(e) {
      e.preventDefault();


      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      var loadnew = $('#loader');
      var btnTextloadnew = $(loadnew).html();

      $.ajax({
        url: `{{url('')}}/admin/manage/options/bank-info/add-new-bank-info-update`,
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
            $('#formSite').trigger('reset');
            // getDepList();
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