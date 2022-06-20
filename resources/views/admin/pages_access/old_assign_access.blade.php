<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Grant Page Access to User"])
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
              <h1 class="m-0">Grant Page Access to User</h1>
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

                <form id="add-new-form">
                  <div class="card-body">

                    <div class="row">
                      @csrf()

                      <div class="col-md-12 mb-4">
                        <div class="form-group">
                          <label>Select Users</label>
                          <select class="form-control select2bs4" name="user_id" id="user_id" style="width: 100%;">
                            <option value="">--Select--</option>
                            @foreach($users as $row)
                            <option value="{{$row->user_id}}">{{$row->username}} - {{$row->designation()->first()->des_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>


                      <div class="col-md-12">
                        <label>Select URLs</label>
                      </div>

                      @foreach($adminUrls as $idx => $url)
                      <div class="col-md-6">
                        <div class="form-check form-check-inline">
                          <div class="form-group">
                            <input type="checkbox" class="form-check-input urls" value="{{$url}}" name="urls[]" id="url_{{$idx}}">
                            <label class="form-check-label" for="url_{{$idx}}">{{$url}}</label>
                          </div>
                        </div>
                      </div>
                      @endforeach

                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Grant Access</button>
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
    $(function() {

      let isAjax = false;
      let frmEle = "#add-new-form";

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
            url: `{{url('')}}/ajax/admin/security/manage/pages/grant-access`,
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

    });
  </script>

</body>

</html>