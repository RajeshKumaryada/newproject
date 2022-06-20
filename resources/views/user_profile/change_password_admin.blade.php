<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ['title'=>'Admin Change Password'])
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
              <h1 class="m-0">Change Your Password</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Change Password</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="work-start-form">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Enter Old Password</label>
                          <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Enter Old Password">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Enter New Password</label>
                          <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Confirm New Password</label>
                          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm New Password">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="start-task-btn" class="btn btn-danger float-right">Change Password</button>
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

  <!-- Page specific script -->
  <script>
    let isAjax = false;
    let formEle = "#work-start-form";
    let frmBtn = "#start-task-btn";

    $(formEle).on('submit', function(e) {
      e.preventDefault();


      if (!isAjax) {
        isAjax = true;
        $("#start-task-btn").attr('disabled', 'true');
        let btnText = $(frmBtn).html();
        activeLoadingBtn(frmBtn);

        let Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/profile/change-password`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              $(formEle).trigger("reset");
            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else if (res.code === 101) {

              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $("#start-task-btn").removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          },
          error: function(status, res, err) {
            if (status.status === 419) {
              alert(status.responseJSON.message, status);
            }
            isAjax = false;
            $("#start-task-btn").removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          }
        });
      }

    });
  </script>
</body>

</html>