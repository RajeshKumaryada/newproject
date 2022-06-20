<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in | Logelite Pvt. Ltd.</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('')}}/layout/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{url('')}}/layout/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('')}}/layout/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{url('')}}/layout/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a class="h2">
          <b>Work Report Portal</b>
          <br>
          Access
        </a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your work</p>

        <form id="login-form">
          <input type="hidden" name="_token" value="{{csrf_token()}}">

          <div class="form-group">
            <select class="form-control" id="work_from" name="work_from">
            <option value="">--Select--</option>
              <option value="1">Work From Office</option>
              <option value="2">Work From Home</option>
            </select>
          </div>

          <div class="form-group input-group mb-3">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="form-group input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <!-- <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div> -->
            </div>
            <!-- /.col -->
            <div class="col-6">
              <button type="submit" id="frm-login-btn" class="btn btn-primary btn-block">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1"></p>

        <!-- <p class="mb-1">
          <a href="#">I forgot my password</a>
        </p> -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="{{url('')}}/layout/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="{{url('')}}/layout/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="{{url('')}}/layout/dist/js/adminlte.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="{{url('')}}/layout/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Logelite -->
  <script src="{{url('')}}/script.js"></script>
  <script>
    let isAjax = false;
    $('#login-form').on('submit', function(e) {
      e.preventDefault();
      let formEle = "#login-form";

      if (!isAjax) {
        isAjax = true;
        $('#frm-login-btn').attr('disabled', 'true');
        let btnText = $('#frm-login-btn').html();
        activeLoadingBtn("#frm-login-btn");

        let Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/auth/user/login`,
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

              setTimeout(function() {
                window.open(res.url, '_self');
              }, 100);

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
            $('#frm-login-btn').removeAttr('disabled');
            resetLoadingBtn("#frm-login-btn", btnText);
          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err)
            isAjax = false;
            $('#frm-login-btn').removeAttr('disabled');
            resetLoadingBtn("#frm-login-btn", btnText);
          }
        });
      }

    });
  </script>
</body>

</html>