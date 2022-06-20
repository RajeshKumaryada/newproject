<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ['title'=>'Submit Work Report'])
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
              <h1 class="m-0">Submit Work Report</h1>
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
                  <h3 class="card-title">Submit Work Report via Excelsheet</h3>
                </div>
                <!-- /.card-header -->



                <div class="card-body">


                  <div class="row">

                    <div class="col-md-12">

                      <div class="row">
                        <div class="col-md-12">
                          Hay, we found some duplicate URLs (given below) in your work report. Please explain briefly what you did on this link.

                          <p class='text-danger'>{{$duplicateLinksMsg}}</p>

                        </div>

                      </div>
                      <div class="row">

                        <div class="col-sm-12 mt-4">
                          <form id="submit-work-report-reason">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">


                            @foreach ($sqlRow as $row)

                            <div class="form-row row">
                              <div class="form-group col-sm-3">
                                <label>Date</label>
                                <div class="form-control">{{$row->seoWorkReport()->first()->date}}</div>
                              </div>

                              <div class="form-group col-sm-3">
                                <label>Title</label>
                                <div class="form-control">{{$row->seoWorkReport()->first()->title}}</div>
                              </div>

                              <div class="form-group col-sm-3">
                                <label>Email</label>
                                <div class="form-control">{{$row->seoWorkReport()->first()->email}}</div>
                              </div>

                              <div class="form-group col-sm-3">
                                <label>Username</label>
                                <div class="form-control">{{$row->seoWorkReport()->first()->username}}</div>
                              </div>

                              <div class="form-group col-sm-12">
                                <label>URL</label>
                                <div class="form-control"><a href="{{urldecode($row->seoWorkReport()->first()->url)}}" target="_blank">{{urldecode($row->seoWorkReport()->first()->url)}}</a></div>
                              </div>

                              <div class="form-group col-sm-12">
                                <label>Reason</label>
                                <textarea name="reason[{{$row->work_report_id}}]" id="reason_{{$row->work_report_id}}" class="form-control border-danger"></textarea>
                              </div>
                            </div>
                            <hr>
                            @endforeach

                            <div class="form-group">
                              <button type="submit" id="frm-sub-btn" class="btn btn-primary float-right">Submit</button>
                            </div>

                          </form>
                        </div>

                      </div>

                    </div>

                  </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">

                </div>

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

    $(function() {


      $('form#submit-work-report-reason').submit(function(e) {
        e.preventDefault();

        if (!isAjax) {

          isAjax = true;
          let frmBtn = "#frm-sub-btn";
          let btnText = $(frmBtn).html();
          $(frmBtn).attr('disabled', 'true');
          activeLoadingBtn(frmBtn);

          let Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
          });

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/seo/submit-work-report/url-answer`,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {

              if (res.code === 200) {

                Toast.fire({
                  icon: 'success',
                  title: res.msg
                });

                setTimeout(function() {
                  window.open("{{url('')}}/seo/submit-work-report", "_self");
                }, 2000);

              } else if (res.code === 100) {
                // showInvalidFields(res.err);
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
              $(frmBtn).removeAttr('disabled');
              resetLoadingBtn(frmBtn, btnText);

            },
            error: function(xhr, status, err) {
              ajaxErrorCalback(xhr, status, err);

              isAjax = false;
              $(frmBtn).removeAttr('disabled');
              resetLoadingBtn(frmBtn, btnText);
            }
          });


        }


      });

    });
  </script>
</body>

</html>