<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ["title"=>"SEO Work Report"])
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
              <h1 class="m-0">SEO Work Report</h1>
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
                  <h3 class="card-title">SEO Work Report</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">

                  <div class="row">

                    <div class="col-md-12 mb-2">
                      <form id="seo-work-report-form">

                        <div class="row">

                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                          <!-- <input type="hidden" name="usertype" value="seo"> -->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Select Users</label>
                              <select class="form-control select2bs4" name="users[]" id="users" style="width: 100%;" multiple></select>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Select Task</label>
                              <select class="form-control select2bs4" name="tasks[]" id="tasks" style="width: 100%;" multiple>
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

                          <div class="col-md-1">
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
                          <!-- <strong>Today Working Hours - <span id="tot_working_hours">0h 0m 0s</span> </strong> -->
                        </div>
                      </div>

                    </div>

                    <div class="col-md-12">

                      <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped d-none" id="data-table-work-report">
                          <thead>
                            <tr>
                              <th scope="col">S.N.</th>
                              <th scope="col">User ID</th>
                              <th scope="col">User Name</th>
                              <th scope="col">User Email</th>
                              <th scope="col">Work Found</th>
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

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->

  @include('user_template.scripts')
  <script>
    var taskInfoTbl;

    $(document).ready(function() {

      getUserList('#users');

      getSeoTaskList('#tasks');

    });


    function getUserList(ele) {
      let url = `{{url('')}}/ajax/seo/view-work-report/user-list/seo`;
      getAjaxData(ele, url, appendChildSelect);
    }


    function getSeoTaskList(ele) {
      let url = `{{url('')}}/ajax/seo/view-work-report/task-list/seo`;
      getAjaxData(ele, url, appendChildSelect);
    }


    let isAjax = false;
    let frmEle = "#seo-work-report-form";

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

        // taskInfoTbl.clear().draw();
        $("#data-table-work-report").find("tr:gt(0)").remove();

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/view-work-report/fetch`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              setTableData("#data-table-work-report", res);
              $("#data-table-work-report").removeClass('d-none');

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

    function setTableData(tbl_id, response) {
      response.data.forEach((ele, index) => {
        addUserInfoRow(ele, index);
      });
    }


    function addUserInfoRow(data, index) {
      let ele = `<tr class="text-white bg-success cur-pointer" data-toggle="collapse" data-target="#target_${index}" aria-expanded="true" aria-controls="target_${index}">
         <td scope="col" style="width: 3%;">
           <span>${index + 1}</span>
          </td>
          <td scope="col">${data.emp_id}</td>
          <td scope="col">${data.emp_name}</td>
          <td scope="col">${data.emp_email}</td>
          <td scope="col">${data.task_count}</td>
        </tr>`;

      $('#data-table-work-report .parent-table-tbody').append(ele);


      let tr = `<tr class="collapse" id="target_${index}">
         <td colspan="5" style="padding: 0;">
         <table class="table table-hover">
         <thead class="thead-light">
           <tr>
             <th scope="col">#</th>
             <th scope="col">Date</th>
             <th scope="col">Task</th>
             <th scope="col">Title</th>
             <th scope="col">Email</th>
             <th scope="col">Username</th>
             <th scope="col">URL</th>
           </tr>
         </thead>
         <tbody>`;


      data.user_data.forEach((ele2, index2) => {

        if (ele2.task === "Other") {
          tr += addRowOther(ele2, index2);
        } else {
          tr += addRow(ele2, index2);
        }

      });

      tr += `</tbody></table></td></tr>`;

      $('#data-table-work-report tr:last').after(tr);
    }


    function addRow(data, index) {

      let url = decodeURIComponent(data.url);

      let ele = `<tr>
        <td scope="col">${index + 1}</td>
        <td scope="col">${data.date}</td>
        <td scope="col">${data.task}</td>
        <td scope="col">${data.title}</td>
        <td scope="col">${data.email}</td>
        <td scope="col">${data.username}</td>
        <td scope="col"><a class="btn-link" href="${url}" title="${url}" target="_blank">${url}</a></td>`;

      ele += `</tr>`;

      return ele;

    }

    function addRowOther(data, index) {
      let ele = `<tr>
        <td scope="col">${index + 1}</td>
        <td scope="col">${data.date}</td>
        <td scope="col">${data.time}</td>
        <td scope="col">${data.task}</td>
        <td scope="col" colspan="5">${data.title}</td>
      </tr>`;

      return ele;

    }
  </script>

</body>

</html>