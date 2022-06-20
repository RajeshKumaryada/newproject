<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ["title"=>"Content Preview for SEOs"])
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
          <div class="row">
            <div class="col-md-12">
              <h1 class="m-0">Content Preview for SEOs</h1>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">


              <div class="card">
                <div class="card-header bg-secondary ui-sortable-handle" style="cursor: move;">
                  <h3 class="card-title">Content Information</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <input type="hidden" id="content_id" value="{{encrypt($content->id)}}">
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <tbody>
                        <tr>
                          <td>1.</td>
                          <th style="min-width: 135px;">Requested User</th>
                          <td colspan="2">
                            {{$content->requestByUser->username}}
                            -
                            {{$content->requestByUser->email}}
                          </td>
                        </tr>
                        <tr>
                          <td>2.</td>
                          <th style="min-width: 135px;">Assigned To</th>
                          <td colspan="2">
                            {{$content->assignToUser->username}}
                            -
                            {{$content->assignToUser->email}}
                          </td>
                        </tr>
                        <tr>
                          <td>3.</td>
                          <th>Title</th>
                          <td colspan="2">
                            {{$content->title}}
                          </td>
                        </tr>
                        <tr>
                          <td>4.</td>
                          <th>Description</th>
                          <td colspan="2">
                            {{$content->description}}
                          </td>
                        </tr>
                        <tr>
                          <td>5.</td>
                          <th>Date Info</th>
                          <td>
                            <strong>Requested Date:</strong> {{$content->request_date}}
                          </td>
                          <td>
                            <strong>Assigned Date:</strong> {{$content->assign_date}}
                          </td>
                        </tr>
                        <tr>
                          <td>6.</td>
                          <th>Req. Words Count</th>
                          <td>
                            {{$content->word_count}}
                          </td>
                          <td class="text-danger">
                            <strong>Status:</strong> <span id="last-status">{{$content->status_str}}</span>
                          </td>
                        </tr>
                        <tr>
                          <td>7.</td>
                          <th>Time Taken</th>
                          <td colspan="2">
                            <strong><span id="timestamps-hours">{!!(!empty($hoursArr)?$hoursArr['work_hours']:'')!!}</span></strong>
                            <button class="btn btn-sm btn-link" id="timestamps-btn">View Timestamps</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="card-footer"></div>

              </div>


              <!-- remark form -->
              <div class="card collapsed-card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                  <h3 class="card-title">Write a Remark about Content</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-danger" data-card-widget="collapse">
                      <i class="fas fa-plus"></i> Open
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <form id="form-write-remark">
                    @csrf()
                    <input type="hidden" id="content_id" name="content_id" value="{{encrypt($content->id)}}">
                    <div class="form-group">
                      <label>Writr your Remark here</label>
                      <textarea name="remark" id="remark" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="form-group">
                      <label>Help Full URL (Optional)</label>
                      <input type="url" name="help_url" id="help_url" class="form-control">
                    </div>

                    <div class="form-group text-right">
                      <button type="submit" class="btn btn-primary smt-btn">Submit Remark</button>
                    </div>
                  </form>


                </div>

                <div class="card-footer"></div>

              </div>
              <!-- end remark form -->


              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-3">
                      <h3 class="card-title">Preview</h3>
                    </div>
                    <div class="col-md-5 text-left">
                      <span class="btn btn-sm btn-link text-danger">Words Count: <span id="done_word_count">0</span></span>
                    </div>
                    <div class="col-md-4 text-right">
                      <strong>Last Update: <span class="text-danger" id="last-update"></span></strong>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div id="content-preview"></div>
                </div>

                <div class="card-footer"></div>

              </div>

            </div>

          </div>

        </div>

      </section>


    </div>
    <!-- /.content-wrapper -->


    <div class="modal fade" id="timestamps-modal" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Content Timestamps</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>

            <div class="table-responsive">
              <table class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                  </tr>
                </thead>
                <tbody id="timestamps-tbody">
                  @foreach($timestamps as $row)
                  <tr>
                    <td>{{(empty($count)?($count = 1):++$count)}}.</td>
                    <td>{{$row->start_time}}</td>
                    <td>{{$row->end_time}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->


  @include('user_template.scripts')

  <script>
    $(function() {
      getContentPreview();
    });

    let toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });

    let isAjax = false;


    $("#form-write-remark").on('submit', function(e) {
      e.preventDefault();

      if (!isAjax) {
        isAjax = true;

        let frmBtn = $(this).children().find('button.smt-btn');

        $(frmBtn).attr('disabled', 'true');

        let btnText = $(frmBtn).html();
        activeLoadingBtn(frmBtn);

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/content-writer/request/content/preview/submit-remark`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: (res) => {

            if (res.code === 200) {

              toast.fire({
                icon: 'success',
                title: res.msg
              });

              $(this).trigger("reset");
            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $(frmBtn).removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          },
          error: (status, res, err) => {
            if (status.status === 419) {
              alert(status.responseJSON.message, status);
            } else {
              ajaxErrorCalback(status, res, err);
            }

            isAjax = false;
            $(frmBtn).removeAttr('disabled');
            resetLoadingBtn(frmBtn, btnText);
          }
        });
      }

    });


    $('#timestamps-btn').on('click', function() {
      $("#timestamps-modal").modal("show");
    });

    const getContentPreview = function() {
      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/content-writer/request/content/preview`,
        data: {
          content_id: $('#content_id').val(),
          _token: $("#csrf_token_ajax").val()
        },
        success: function(res) {

          if (res.code === 200) {
            // $('#content-preview').html(res.data.content_edits.content);
            if(res.data.content_edits.status == 'Approved'){
              $('#content-preview').html(`<a class="btn btn-danger mb-2"  href="{{url('')}}/content/user/preview/${res.data.content_edits.new_content_id}" download>Download Content File</a>`+res.data.content_edits.content);
            }else{
              $('#content-preview').html('');
            }
            
            $('#last-update').html(res.data.content_edits.time_last_update.end_time);
            $('#last-status').html(res.data.status_str);
            $('#done_word_count').html(res.data.done_word_count);

            $('#timestamps-hours').html(res.hoursArr.work_hours);

            let timestampsTbody = '';

            res.timestamps.forEach((ele, idx) => {
              timestampsTbody += `<tr>
                    <td>${idx}.</td>
                    <td>${ele.start_time}</td>
                    <td>${ele.end_time}</td>
                  </tr>`;
            });
            $('#timestamps-tbody').html(timestampsTbody);
          } else {
            toast.fire({
              icon: 'error',
              title: res.msg
            });
          }



        },
        error: function(status, res, err) {
          ajaxErrorCalback(xhr, status, err);
        }
      });
    }
  </script>
  @if($content->status === 3 || $content->status === 4)
  <script>
    setInterval(getContentPreview, (1000 * 60));
  </script>
  @endif



</body>

</html>