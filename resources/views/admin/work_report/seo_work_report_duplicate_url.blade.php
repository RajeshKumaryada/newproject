<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"SEO Work Report Duplicate URLs"])

  <style>
    .table-container {
      padding: 10px 0 !important;
    }

    .table-container table {
      border: 2px solid #949494 !important;
    }
 #table_scoll1, #table_scoll2{width: 100%; 
overflow-x: scroll; overflow-y:hidden;}
#table_scoll1{height: 20px; }
#table_scoll2{height: 100px; }
#div1 {width:100%; height: 20px; }
#div2 {width:100%; height: auto; 
overflow: auto;}

@media only screen and (min-width: 320px) and (max-width: 767px) {
    .cardtitle_h1{padding-top: 49px;}
}
  </style>
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
              <h1 class="m-0 cardtitle_h1">SEO Work Report Duplicate URLs</h1>
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
              <div class="card card-secondary">
                <div class="card-header">
                  <div class="row">
                    <div class="col-sm-8">
                      <h3 class="card-title">SEO Work Report Duplicate URLs</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                      <button value="0" class="btn btn-danger text-white border-white d-none" id="btn-reset-last-seen" disabled>#</button value="0">
                    </div>
                  </div>

                </div>
                <!-- /.card-header -->

                <div class="card-body">

                  <div class="row">

                    <div class="col-md-12 mb-2">
                      <form id="form-duplicate-url">

                        <div class="row">

                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Select Users</label>
                              <select class="form-control select2bs4" name="users" id="users" style="width: 100%;">
                                <option value="all">All Users</option>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Select Task</label>
                              <select class="form-control select2bs4" name="tasks" id="tasks" style="width: 100%;">
                                <option value="all">All Task</option>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label>Start Date</label>
                              <input type="date" name="start_date" id="start_date" value="{{date('Y-m-d')}}" class="form-control" placeholder="Enter ...">
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label>End Date</label>
                              <input type="date" name="end_date" id="end_date" value="{{date('Y-m-d')}}" class="form-control" placeholder="Enter ...">
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label>&nbsp;</label>
                              <button type="submit" id="frm-submit-btn" class="btn btn-success form-control">Get Details</button>
                            </div>
                          </div>

                        </div>
                      </form>

                      <hr>

                    </div>

                    <div class="col-md-12 mb-4">
                      <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 text-right">

                        </div>
                      </div>

                    </div>

                    <div class="col-md-12">

                      <div id="table_scoll1">
                          <div id="div1">
                          </div>
                      </div>
                      <div id="table_scoll2" class="tableresponsive">
                        <table id="div2" class="table table-bordered table-hover" id="data-table-seo-work-duplicate-url">
                          <thead>
                            <tr>
                              <th scope="col">S.N.</th>
                              <th scope="col">Date</th>
                              <th scope="col">Time</th>
                              <th scope="col">Task</th>
                              <th scope="col">Title</th>
                              <th scope="col">Email</th>
                              <th scope="col">Username</th>
                              <th scope="col">Password</th>
                              <th scope="col">URL</th>
                            </tr>
                          </thead>
                          <tbody class="parent-table-tbody"></tbody>
                        </table>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="card-footer"></div>


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
    var taskInfoTbl;

    $(document).ready(function() {

      getUserList('#users');

      getSeoTaskList('#tasks');


      fetchSeoWorkDuplicateUrl();

    });


    function getUserList(ele) {
      let url = `{{url('')}}/ajax/admin/work-report/user-list/seo`;
      getAjaxData(ele, url, appendChildSelect);
    }


    function getSeoTaskList(ele) {
      let url = `{{url('')}}/ajax/admin/work-report/seo-task-list`;
      getAjaxData(ele, url, appendChildSelect);
    }


    $("#data-table-seo-work-duplicate-url").on('click', '.parent-open', function() {
      let targetEle = $(this).data('reportid');
      // console.log(targetEle);
      $(`#more${targetEle}`).collapse('hide');
    });


    function fetchSeoWorkDuplicateUrl() {
      let url = `{{url('')}}/ajax/admin/work-report/seo/duplicate-urls`;
      getAjaxData('#data-table-seo-work-duplicate-url', url, _fetchSeoWorkDuplicateUrlCallback);
    }


    function _fetchSeoWorkDuplicateUrlCallback(ele, response) {

      if (response.data.length > 0) {
        response.data.forEach(function(row, idx) {
          addRowDuplicateUrl(row, idx);
        });

        if (response.last_seen_id !== '' && response.last_seen_id !== null && response.last_seen_id !== undefined) {
          $("#btn-reset-last-seen").val(response.last_seen_id);
          $("#btn-reset-last-seen").html(`New URLs: ${response.last_seen_id}`);
          $("#btn-reset-last-seen").removeClass('d-none');
          $('#btn-reset-last-seen').removeAttr('disabled');
        }
      }
    }


    function addRowDuplicateUrl(data, idx) {
      // console.log(data);
      let url = decodeURIComponent(data.url);
      let dt = data.created_at.split(" ");

      let ret = `<tr class="cur-ptr parent-open" data-toggle="collapse" data-reportid="${data.work_report_id}" data-target="#target${data.work_report_id}" aria-expanded="false" aria-controls="target${data.work_report_id}">
        <td><span class="btn btn-sm btn-success">${idx + 1}</span></td>
        <td scope="col">${dt[0]}</td>
        <td scope="col">${dt[1]}</td>
        <td scope="col">${data.task}</td>
        <td scope="col">${data.title}</td>
        <td scope="col">${data.email}</td>
        <td scope="col">${data.username}</td>
        <td scope="col">${data.password}</td>
        <td scope="col"><a href=${url} target="_blank" class="btn-link">${url}</a></td>
        </tr>`;

      let reason = data.reason;

      if (data.exclude_from_url_check === 1) {
        reason = "This Task is exclude from duplicate URL check.";
      }

      ret += `<tr class="collapse" id="target${data.work_report_id}">
          <td colspan="2"><strong>By User: </strong> ${data.emp_name} (${data.des_name})</td>
          <td colspan="6"><strong>Reason: </strong> ${reason}</td>
          <td><button value="${data.id},${data.user_id},${data.url}" data-moreid="more${data.work_report_id}" class="btn btn-info btn-sm btn-block btn-more-links" >View Previous Enterd URLs</button></td>
          </tr>`;

      ret += `<tr class="collapse" id="more${data.work_report_id}">
          <td class="table-container" colspan="9"></td>
          </tr>`;

      $('#data-table-seo-work-duplicate-url tbody').append(ret);
    }



    $("#data-table-seo-work-duplicate-url").on('click', '.btn-more-links', function() {

      let targetEle = $(this).data('moreid');
      $(`#${targetEle} td`).html('');

      $.ajax({
        type: 'POST',
        url: `{{url('')}}/ajax/admin/work-report/seo/duplicate-urls-more`,
        data: {
          value: $(this).val(),
          _token: $('#csrf_token_ajax').val()
        },
        success: function(res) {
          if (res.code === 200) {
            addMoreRowDuplicateUrl(res.data, targetEle);
            $(`#${targetEle}`).collapse('show');
          } else if (res.code === 204) {
            $(`#${targetEle} td`).html("No Data");
          }
        },
        error: function(xhr, status, err) {
          ajaxErrorCalback(xhr, status, err);
        }
      });
    });


    function addMoreRowDuplicateUrl(data, targetEle) {
      let ele = `<table class="table table-hover"><tbody>`;

      data.forEach(function(row, idx) {
        let dt = row.date.split(" ");
        let url = decodeURIComponent(row.url);
        ele += `<tr class="cur-ptr" data-toggle="collapse" data-target="#target${row.work_report_id}_${idx}" aria-expanded="false" aria-controls="target${row.work_report_id}_${idx}">
            <td><span class="btn btn-sm btn-warning">${idx + 1}</span></td>
            <td scope="col">${dt[0]}</td>
            <td scope="col">${dt[1]}</td>
            <td scope="col">${row.task}</td>
            <td scope="col">${row.title}</td>
            <td scope="col">${row.email}</td>
            <td scope="col">${row.username}</td>
            <td scope="col">${row.password}</td>
            <td scope="col"><a href=${url} target="_blank" class="btn-link">${url}</a></td>
            </tr>`;

        ele += `<tr class="collapse" id="target${row.work_report_id}_${idx}">
            <td colspan="9"><strong>Reason: </strong> ${row.reason}</td>
            </tr>`;
      });

      ele += `</tbody></table>`;

      $(`#${targetEle} td`).html(ele);
    }

    let isAjax = false;
    let frmEle = "#form-duplicate-url";

    $(frmEle).on('submit', function(e) {
      e.preventDefault();


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
          url: `{{url('')}}/ajax/admin/work-report/seo/duplicate-urls-form`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {
            $("#data-table-seo-work-duplicate-url tbody").find("tr").remove();

            if (res.code === 200) {

              if (res.data.length <= 0) {
                Toast.fire({
                  icon: 'error',
                  title: "No data found!"
                });
              } else {
                _fetchSeoWorkDuplicateUrlCallback('#data-table-seo-work-duplicate-url', res);
                // $("#btn-reset-last-seen").val(res.last_seen_id);
              }

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


    isAjax = false;

    $("#btn-reset-last-seen").on('click', function() {

      let lastSeenId = $(this).val();

      if (lastSeenId == null || lastSeenId == NaN || lastSeenId == '') {
        return;
      }

      if (!isAjax) {
        isAjax = true;

        $(this).attr('disabled', 'true');
        let btnText = $(this).html();
        activeLoadingBtn(this);

        let Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/admin/work-report/seo/duplicate-urls-update-last-seen`,
          data: {
            reset_id: lastSeenId,
            _token: $('#csrf_token_ajax').val()
          },
          success: function(res) {
            if (res.code === 200) {
              // $("#dup-url-noti").html('');
              // $("#dup-url-noti").removeClass('notify');
              $("#btn-reset-last-seen").addClass('d-none');
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
              $('#btn-reset-last-seen').removeAttr('disabled');
              resetLoadingBtn("#btn-reset-last-seen", btnText);
            }

            isAjax = false;

          },
          error: function(xhr, status, err) {
            ajaxErrorCalback(xhr, status, err);
            isAjax = false;
            $('#btn-reset-last-seen').removeAttr('disabled');
            resetLoadingBtn("#btn-reset-last-seen", btnText);
          }
        });
      }


    });

    var table_scoll1 = document.getElementById('table_scoll1');
var table_scoll2 = document.getElementById('table_scoll2');
table_scoll1.onscroll = function() {
  table_scoll2.scrollLeft = table_scoll1.scrollLeft;
};
table_scoll2.onscroll = function() {
  table_scoll1.scrollLeft = table_scoll2.scrollLeft;
};
  </script>

</body>

</html>