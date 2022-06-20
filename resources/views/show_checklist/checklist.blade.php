<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ['title'=>'Verify before start work'])
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
              <h1 class="m-0">Verify before start work</h1>
            </div>
          </div>
        </div>
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
                  <h3 class="card-title">Verify it</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="work-start-form">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12">
                        @foreach($checklist as $row)

                        <div class="form-check form-check-inline">
                          <div class="form-group">
                            <input type="checkbox" class="form-check-input" value="{{$row->checklist_id}}_1" name="checklist_{{$row->checklist_id}}" id="checklist_{{$row->checklist_id}}">
                            <label class="form-check-label" for="checklist_{{$row->checklist_id}}">{{$row->checklist_text}}</label>
                          </div>
                        </div>

                        @endforeach

                      </div>

                    </div>


                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="start-task-btn" class="btn btn-primary float-right">Verify</button>
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

  <!-- Page specific script -->
  <script>
    let isAjax = false;
    let formEle = "#work-start-form";
    let frmBtn = "#start-task-btn";

    $(formEle).on('submit', function(e) {
      e.preventDefault();


      if (!isAjax) {
        isAjax = true;
        $(this).children('div.card-footer').children('button[type=submit]').attr('disabled', 'true');
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
          url: `{{url('')}}/ajax/checklist/verify`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              window.open(res.url, '_self');
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
                title: 'Undefined response.'
              });
            }

            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          },
          error: function(status, res, err) {
            if (status.status === 419) {
              alert(status.responseJSON.message, status);
            }
            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          }
        });
      }

    });
  </script>
</body>

</html>