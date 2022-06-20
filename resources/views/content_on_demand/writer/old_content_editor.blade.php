<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ["title"=>"Content Editor for Writers"])


  @if(session()->has('cw_edits_info'))
  <!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
  <!-- include summernote css-->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
  @endif
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
            <div class="col-md-12">
              <h1 class="m-0">Content Editor for Writers</h1>
            </div>
          </div>
        </div>
      </div>





      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">


              <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                  <h3 class="card-title">Content Information</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">

                  <div class="table-responsive">
                    <table class="table table-sm">
                      <tbody>
                        <tr>
                          <td>1.</td>
                          <th style="min-width: 135px;">Requested User</th>
                          <td colspan="2">
                            {{$taskInfo->requestByUser->username}}
                            -
                            {{$taskInfo->requestByUser->email}}
                          </td>
                        </tr>
                        <tr>
                          <td>2.</td>
                          <th>Title</th>
                          <td colspan="2">
                            {{$taskInfo->title}}
                          </td>
                        </tr>
                        <tr>
                          <td>3.</td>
                          <th>Description</th>
                          <td colspan="2">
                            {{$taskInfo->description}}
                          </td>
                        </tr>
                        <tr>
                          <td>4.</td>
                          <th>Date Info</th>
                          <td>
                            <strong>Requested Date:</strong> {{$taskInfo->request_date}}
                          </td>
                          <td>
                            <strong>Assigned Date:</strong> {{$taskInfo->assign_date}}
                          </td>
                        </tr>
                        <tr>
                          <td>5.</td>
                          <th>Req. Words Count</th>
                          <td>
                            {{$taskInfo->word_count}}
                          </td>
                          <td class="text-danger">
                            <strong>Status:</strong> {{$taskInfo->status}}
                          </td>
                        </tr>
                        <tr>
                          <td>6.</td>
                          <th>Time Taken</th>
                          <td colspan="2">
                            <strong><span id="timestamps-hours">{!!(!empty($hoursArr)?$hoursArr['work_hours']:'')!!}</span></strong>
                            <button class="btn btn-sm btn-link" id="timestamps-btn">View Timestamps</button>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4"><strong>Note:</strong> While editing, your content will autosave every 1 minute.</td>
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
                    <input type="hidden" id="content_id" name="content_id" value="{{encrypt($taskInfo->id)}}">
                    <div class="form-group">
                      <label>Writr your Remark here</label>
                      <textarea name="remark" id="remark" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="form-group text-right">
                      <button type="submit" class="btn btn-primary smt-btn">Submit Remark</button>
                    </div>
                  </form>


                </div>

                <div class="card-footer"></div>

              </div>
              <!-- end remark form -->


              @if(session()->has('cw_edits_info'))

              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="card-title">Editor</h3>
                    </div>
                    <div class="col-md-4 text-right">
                      <button type="button" id='draft-content' class="btn btn-primary">Save as Draft</button>
                    </div>
                  </div>
                </div>

                <form id="content-editor">
                  @csrf()
                  <input type="hidden" name="content_id" id="content_id" value="{{encrypt($taskInfo->id)}}">
                  <div class="card-body">
                    <div class="form-group">
                      <textarea name="content" id="content" class="form-control" style="height: fit-content;min-height: 400px;">{{htmlspecialchars_decode($taskInfo->contentEdits->content)}}</textarea>
                    </div>
                  </div>

                  <div class="card-footer">
                    <span class="btn btn-outline-danger">Words Count: <span id="show-word-counts">{{Fns::init()->wordCount(htmlspecialchars_decode($taskInfo->contentEdits->content))}}</span></span>
                    <button type="submit" id="frm-submit-btn" class="btn btn-danger float-right">Finish</button>
                  </div>

                </form>

                <!-- endif -->

              </div>

              @else

              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="card-title">Editor</h3>
                    </div>
                    <div class="col-md-4 text-right">
                      <button type="button" class="btn btn-outline-danger" id="start-edit">
                        Start Edit
                      </button>
                    </div>
                  </div>
                </div>



                @if(empty($taskInfo->contentEdits))

                <div id="content-editor">
                  @csrf()
                  <input type="hidden" name="content_id" id="content_id" value="{{encrypt($taskInfo->id)}}">
                  <div class="card-body">
                    <div class="form-group">
                      <div name="content" id="content" class="form-control" style="height: fit-content;min-height: 400px;">Please click on <strong>Start Edit</strong> button to start your content writing task.</div>
                    </div>
                  </div>
                </div>

                @else

                <div id="content-editor">
                  @csrf()
                  <input type="hidden" name="content_id" id="content_id" value="{{encrypt($taskInfo->id)}}">
                  <div class="card-body">
                    <div class="form-group">
                      <div class="form-control" style="height: fit-content;min-height: 400px;">{!!htmlspecialchars_decode($taskInfo->contentEdits->content)!!}</div>
                    </div>
                  </div>

                  <div class="card-footer">
                    <span class="btn btn-outline-danger">Words Count: <span id="show-word-counts">{{Fns::init()->wordCount(htmlspecialchars_decode($taskInfo->contentEdits->content))}}</span></span>
                  </div>

                </div>

                @endif

              </div>

              @endif





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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    var isAjax = false;

    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });


    //start edit action
    $('#start-edit').on('click', function() {

      if (!confirm('Are you sure to start edit?')) {
        return;
      }

      if (!isAjax) {
        isAjax = true;

        $(this).attr('disabled', 'true');
        let btnText = $(this).html();
        activeLoadingBtn(this);

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/content-writer/assigned/edit/start`,
          data: {
            content_id: $("#content_id").val(),
            _token: $("#csrf_token_ajax").val()
          },
          success: function(res) {

            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              window.location.reload();

            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $(this).removeAttr('disabled');
            resetLoadingBtn(this, btnText);
          },
          error: function(status, res, err) {
            if (status.status === 419) {
              alert(status.responseJSON.message, status);
            }
            isAjax = false;
            $(this).removeAttr('disabled');
            resetLoadingBtn(this, btnText);
          }
        });
      }

    });


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
          url: `{{url('')}}/ajax/content-writer/content/assigned/edit/submit-remark`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: (res) => {

            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              $(this).trigger("reset");
            } else if (res.code === 100) {
              showInvalidFields(res.err);
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
  </script>

  @if(session()->has('cw_edits_info'))
  <!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
  <!-- include summernote js-->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
  <script>
    $('#content').summernote({
      placeholder: 'Write your content here',
      tabsize: 0,
      height: 400,
      minHeight: 400,
      codemirror: {
        theme: 'monokai'
      },
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ],
      callbacks: {
        onChange: function(contents, $editable) {
          $('#show-word-counts').html(wordCounter(contents));
        }
      }
    });

    let oldContent = `{!!$taskInfo->contentEdits->content!!}`;

    let toastTop = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });

    // console.log(oldContent);
    const autoSaveContent = function() {
      let content = $('#content').val();

      if (content == null || content == undefined || content == '') {
        return;
      } else if (content == oldContent) {
        return;
      }

      oldContent = content;



      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/content-writer/assigned/edit/auto-save`,
        data: {
          content: content,
          _token: $("#csrf_token_ajax").val()
        },
        success: function(res) {

          if (res.code === 200) {

            toastTop.fire({
              icon: 'success',
              title: res.msg
            });

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
            toastTop.fire({
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
    setInterval(autoSaveContent, (1000 * 60));



    $('#content').next().find(".note-editable").attr("onpaste", 'return false');

    $('#content').on('summernote.paste', function(e) {

      swal({
        text: "Paste content restricted.Please write your content!",
        icon: "info",
      });
    

      console.log('Called event paste');
    });




    // 





    // $('#summernote').on('summernote.focus', function(e) {
    //   // console.log('Editable area is focused');
    //   e.preventDefault();
    //   $(this).find(".note-editable").attr("onpaste", 'return false');

    // });


    // $('.note-editable .card-block').on('click',function(){
    //     $('.note-editable .card-block').addClass('ssss');
    // });



    $('#draft-content').on('click', function() {


      if (!isAjax) {
        isAjax = true;
        $("#frm-submit-btn").attr('disabled', 'true');
        $(this).attr('disabled', 'true');
        let btnText = $(this).html();
        activeLoadingBtn(this);


        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/content-writer/assigned/edit/draft-save`,
          data: new FormData(document.getElementById('content-editor')),
          contentType: false,
          processData: false,
          success: (res) => {

            if (res.code === 200) {

              toastTop.fire({
                icon: 'success',
                title: res.msg
              });

              window.location.reload();

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              toastTop.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $("#frm-submit-btn").removeAttr('disabled');
            $(this).removeAttr('disabled');
            resetLoadingBtn(this, btnText);
          },
          error: (status, res, err) => {
            if (status.status === 419) {
              alert(status.responseJSON.message, status);
            }

            isAjax = false;
            $("#frm-submit-btn").removeAttr('disabled');
            $(this).removeAttr('disabled');
            resetLoadingBtn(this, btnText);
          }
        });
      }

    });


    $("#content-editor").on('submit', function(e) {
      e.preventDefault();

      let content = $('#content').val();
      let counts = `{{$taskInfo->word_count}}`;
      let wordsCount = wordCounter(content);

      if (content == null || content == undefined || content == '' || wordsCount <= 1) {
        Toast.fire({
          icon: 'error',
          title: "Too Short Content!"
        });
        return;
      }



      if (wordsCount < counts) {
        if (!confirm(`You wrote ${wordsCount} words, but need to write ${counts}. Are you sure to finish?`)) {
          return;
        }
      } else if (!confirm('Are you sure to finish, you can\'t make changes after this?')) {
        return;
      }



      if (!isAjax) {
        isAjax = true;
        $("#frm-submit-btn").attr('disabled', 'true');
        let btnText = $("#frm-submit-btn").html();
        activeLoadingBtn("#frm-submit-btn");

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/content-writer/content/assigned/edit/save`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              window.location.reload();

            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $("#frm-submit-btn").removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          },
          error: function(status, res, err) {
            if (status.status === 419) {
              alert(status.responseJSON.message, status);
            }
            isAjax = false;
            $("#frm-submit-btn").removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          }
        });
      }

    });
  </script>
  @endif

</body>

</html>