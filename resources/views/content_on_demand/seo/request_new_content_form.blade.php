<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ["title"=>"Ask for new Content"])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    @include('user_template.nav')


    @include('user_template.aside')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0">Ask for new Content</h1>
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

                <form id="content-demand-form">
                  @csrf()
                  <div class="card-body">
                    <div class="row">

                      <div class="col-md-9">
                        <div class="form-group">
                          <label>Content Title</label>
                          <input type="text" name="content_title" id="content_title" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Word Counts</label>
                          <input type="number" name="word_counts" id="word_counts" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Content Descreption</label>
                          <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                        </div>
                      </div>

                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Request</button>
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

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->

  @include('user_template.scripts')

  <script>
    let isAjax = false;
    let frmBtn = "#frm-submit-btn";


    $("#content-demand-form").on('submit', function(e) {
      e.preventDefault();

      if (!isAjax) {
        isAjax = true;
        $("#frm-submit-btn").attr('disabled', 'true');
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
          url: `{{url('')}}/ajax/seo/request/content/new`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              $("#content-demand-form").trigger("reset");
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
            $("#frm-submit-btn").removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          },
          error: function(status, res, err) {
            if (status.status === 419) {
              alert(status.responseJSON.message, status);
            }
            isAjax = false;
            $("#frm-submit-btn").removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          }
        });
      }

    });
  </script>


</body>

</html>