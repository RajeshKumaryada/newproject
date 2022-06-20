<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Add New Working Time"])
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
              <h1 class="m-0">Add New Working Time</h1>
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
                  <h3 class="card-title">Minimum Working Duration In a Day</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="formOptionTime">
                  @csrf
                  <div class="card-body">

                    <div class="row">
                      <input type="hidden" name="option_id" value="">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Enter Time</label>
                          <input type="time" name="opt_value" id="opt_value" class="form-control" value="{{ $data->opt_value }}" placeholder="Enter Message">
                        </div>
                      </div>
                    </div>
                 </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Update</button>
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
    $("#formOptionTime").on("submit", function(e) {
      e.preventDefault();


      if (!confirm('Are You sure want to change Time')) {
        return;
      }

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      var load = $('#loader');
        var btnTextload = $(load).html();

      $.ajax({
        url: `{{url('')}}/admin/manageoptions/work-time/add-new-work-time`,
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
  </script>

</body>

</html>