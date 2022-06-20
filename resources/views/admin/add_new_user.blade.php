<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Add New User"])
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
              <h1 class="m-0">Add New User</h1>
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

                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>User Email</label>
                          <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Username</label>
                          <input type="text" name="username" id="username" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Password</label>
                          <div class="form-group input-group">
                            <input type="text" name="password" id="password" class="form-control" placeholder="Enter ...">
                            <div class="input-group-append cur-pointer" id="generate-password">
                              <span class="input-group-text"><i class="fas fa-check text-success"></i> &nbsp; Generate</span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Department</label>
                          <select class="form-control select2bs4" name="department" id="department" style="width: 100%;">
                            <option value="">--Select--</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Post</label>
                          <select class="form-control select2bs4" name="post" id="post" style="width: 100%;">
                            <option value="">--Select--</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Designation</label>
                          <select class="form-control select2bs4" name="designation" id="designation" style="width: 100%;">
                            <option value="">--Select--</option>
                          </select>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Add Employee</button>
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
    $(document).ready(function() {

      let url = `{{url('')}}/ajax/department/all-list`;
      getAjaxData('#department', url, appendChildSelect);
      // });

      // $(document).ready(function() {
      url = `{{url('')}}/ajax/post/all-list`;
      getAjaxData('#post', url, appendChildSelect);
      // });

      // $(document).ready(function() {
      url = `{{url('')}}/ajax/designation/all-list`;
      getAjaxData('#designation', url, appendChildSelect);
    });

    $("#generate-password").on('click', function() {
      // let val = $(this).siblings('input').val();
      // if (val == '' || val == undefined || val == null) {
      $(this).siblings('input').val(generatePassword());
      // }
    });

    $("#password").on('focus', function() {
      let val = $(this).val();
      if (val == '' || val == undefined || val == null) {
        $(this).val(generatePassword());
      }
    });


    $("#username").on('focus', function() {
      let val = $(this).val();
      if (val == '' || val == undefined || val == null) {
        $(this).val(generateUsername($("#user_email").val()));
        $(this).select();
      }
    });

    
    let isAjax = false;
    $('#add-user-form').on('submit', function(e) {
      e.preventDefault();
      let formEle = "#add-user-form";
      if (!isAjax) {
        isAjax = true;
        $(this).children('div.card-footer').children('button[type=submit]').attr('disabled', 'true');
        let btnText = $('#frm-submit-btn').html();
        activeLoadingBtn("#frm-submit-btn");

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/user/add-new`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {
            // console.log(res);

            // let data = JSON.parse(res);
            if (res.code === 200) {
              // toastr.success(res.msg);

              var Toast = Swal.mixin({
                toast: true,
                position: 'center',
                showConfirmButton: false,
                timer: 3000
              });
              Toast.fire({
                icon: 'success',
                title: res.msg
              })
              $("#add-user-form").trigger("reset");
              $(".select2bs4").val('').trigger('change');
            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              alert(res.msg);
            }

            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          },
          error: function(xhr, status) {
            ajaxErrorCalback(xhr, status)
            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          }
        });
      }

    });
  </script>
  
</body>

</html>