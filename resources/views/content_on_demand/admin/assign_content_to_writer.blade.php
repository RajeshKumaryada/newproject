<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Assign Content to Writer"])
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
              <h1 class="m-0">Assign Content to Writer</h1>
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
                  <h3 class="card-title">Assign Content to Writer</h3>
                </div>
                <!-- /.card-header -->

                <form id="content-demand-form">
                  @csrf()
                  <input type="hidden" name="content_id" value="{{encrypt($contentInfo->id)}}">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-md-9">
                        <div class="form-group">
                          <label>Content Title</label>
                          <div class="form-control">{{$contentInfo->title}}</div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Word Counts</label>
                          <div class="form-control">{{$contentInfo->word_count}}</div>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Content Descreption</label>
                          <div class="form-control" style="height: fit-content;">{{$contentInfo->description}}</div>
                        </div>
                      </div>

                    </div>


                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Assign to</label>
                          <select class="form-control" name="assign_to">
                            <option value="">--Select--</option>
                            @foreach($seoUsers as $row)

                            @if($contentInfo->assign_to == $row->user_id)

                            <option value="{{$row->user_id}}" selected>{{$row->username}}</option>

                            @else

                            <option value="{{$row->user_id}}">{{$row->username}}</option>

                            @endif


                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Help URL (Optional)</label>

                          @if(!empty($contentInfo->assign_to))
                          <div class="form-control">
                            <a href="{{$contentInfo->contentRemarks()->first()->help_url}}" target="_blank" rel="noopener noreferrer">
                              {{$contentInfo->contentRemarks()->first()->help_url}}
                            </a>
                          </div>
                          @else
                          <input type="url" name="help_url" id="help_url" class="form-control" placeholder="Enter ...">
                          @endif
                        </div>
                      </div>
                    </div>



                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Remarks (Optional)</label>

                          @if(!empty($contentInfo->assign_to))
                          <div class="form-control" style="height: fit-content;min-height: 124px;">{{$contentInfo->contentRemarks()->first()->remark_admin}}</div>
                          @else
                          <textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
                          @endif

                        </div>

                      </div>

                      @if(!empty($contentInfo->assign_date))
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Assigned Date</label>
                          <div class="form-control text-bold">{{$contentInfo->assign_date}}</div>
                        </div>
                      </div>
                      @endif

                    </div>

                    <div class="row">




                    </div>

                  </div>

                  <div class="card-footer">

                    <a href="{{url('')}}/admin/request/content/list" class="btn btn-secondary">Back to List</a>

                    <button type="submit" id="frm-submit-btn" class="btn btn-primary float-right">Assign Content</button>
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
          url: `{{url('')}}/ajax/admin/request/content/assign/save`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              setTimeout(() => {
                window.location.replace(`{{url('')}}/admin/request/content/list`);
              }, 1000);

              // $("#content-demand-form").trigger("reset");
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