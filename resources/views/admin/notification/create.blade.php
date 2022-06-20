<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Create New Notification"])
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
              <h1 class="m-0">Create New Notification</h1>
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


                      <div class="col-md-12">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                          <label>Select Users</label>
                          <select class="form-control select2bs4" name="user_list[]" id="user_list" style="width: 100%;" multiple>
                            @foreach($userGroups as $key => $val)

                            <optgroup label="{{strtoupper($key)}}">
                              @foreach($val as $key2 => $val2)
                              <option value="{{$key2}}">{{$val2}}</option>
                              @endforeach
                            </optgroup>

                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Write Notification</label>
                          <textarea class="form-control" name="notification" id="notification" rows="5" placeholder="Enter your message"></textarea>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">

                    <div class="float-left">
                      <a href="{{url('')}}/admin/notification/list" class="btn btn-link">Back to List</a>
                    </div>

                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Create</button>
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
          url: `{{url('')}}/ajax/admin/notification/create`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

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
  </script>

</body>

</html>