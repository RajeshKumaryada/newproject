<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Edit User"])
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
              <h1 class="m-0">Edit User - {{$user->username}}</h1>
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
                  <h3 class="card-title">Edit Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="edit-user-form">
                  <div class="card-body">
                    <div class="row">

                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                      <input type="hidden" name="user_id" value="{{$user->user_id}}">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>User Email</label>
                          <input type="email" name="user_email" value="{{$user->email}}" id="user_email" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Username</label>
                          <input type="text" name="username" value="{{$user->username}}" id="username" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Password (<small>Leave it blank, if dont want to change.</small>)</label>
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
                          <input type="hidden" id="user_department" value="{{$user->department}}">
                          <select class="form-control select2bs4" name="department" id="department" style="width: 100%;">
                            <option value="">--Select--</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Post</label>
                          <input type="hidden" id="user_post" value="{{$user->post}}">
                          <select class="form-control select2bs4" name="post" id="post" style="width: 100%;">
                            <option value="">--Select--</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Designation</label>
                          <input type="hidden" id="user_designation" value="{{$user->designation}}">
                          <select class="form-control select2bs4" name="designation" id="designation" style="width: 100%;">
                            <option value="">--Select--</option>
                          </select>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">
                    <a href="{{url('')}}/admin/user/manage" class="btn btn-dark">Back to List</a>
                    <button type="submit" id="frm-submit-btn" class="btn btn-danger float-right">Update</button>
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
      getAjaxData('#department', url, appendChildSelect2.bind({
        match: $('#user_department').val()
      }));


      url = `{{url('')}}/ajax/post/all-list`;
      getAjaxData('#post', url, appendChildSelect2.bind({
        match: $('#user_post').val()
      }));


      url = `{{url('')}}/ajax/designation/all-list`;
      getAjaxData('#designation', url, appendChildSelect2.bind({
        match: $('#user_designation').val()
      }));
    });

    $("#generate-password").on('click', function() {
      $(this).siblings('input').val(generatePassword());
    });

    let isAjax = false;
    let frmEle = "#edit-user-form";

    $(frmEle).on('submit', function(e) {
      e.preventDefault();
      let formEle = frmEle;
      if (!isAjax) {
        isAjax = true;
        $('#frm-submit-btn').attr('disabled', 'true');
        let btnText = $('#frm-submit-btn').html();
        activeLoadingBtn("#frm-submit-btn");

        var Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/user/manage/edit`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              // $(frmEle).trigger("reset");
              // $(".select2bs4").val('').trigger('change');
            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              // alert(res.msg);
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
  </script>

</body>

</html>