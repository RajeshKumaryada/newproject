<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"SEO Work Report"])
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


                      <!-- <table id="user-task-tbl" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Task</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Time</th>
                            <th>Status</th>
                            <th>Remarks</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Task</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Time</th>
                            <th>Status</th>
                            <th>Remarks</th>
                          </tr>
                        </tfoot>
                      </table> -->
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

      // $("#data-table-work-report").DataTable({
      //   "paging": false,
      //   "responsive": true,
      //   "lengthChange": false,
      //   "autoWidth": false,
      //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      // }).buttons().container().appendTo('#data-table-work-report_wrapper .col-md-6:eq(0)');

      // taskInfoTbl = $("#data-table-work-report").DataTable();

      getUserList('#users');

      getSeoTaskList('#tasks');

    });


    function getUserList(ele) {
      let url = `{{url('')}}/ajax/admin/work-report/user-list/seo`;
      getAjaxData(ele, url, appendChildSelect);
    }


    function getSeoTaskList(ele) {
      let url = `{{url('')}}/ajax/admin/work-report/seo-task-list`;
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
          url: `{{url('')}}/ajax/admin/work-report/fetch`,
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

      //   $('#data-table-work-report tr:last').after(ele);
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
             <th scope="col">Password</th>
             <th scope="col">URL</th>
             <th scope="col">Task Images</th>
           </tr>
         </thead>
         <tbody>`;


      data.user_data.forEach((ele2, index2) => {

        // console.log(ele2.task);
        if (ele2.task === "Other") {
          tr += addRowOther(ele2, index2);
        } else {
          tr += addRow(ele2, index2);
          // links.push(decodeURIComponent(decodeURIComponent(ele2.url)));
        }

      });

      tr += `</tbody></table></td></tr>`;

      $('#data-table-work-report tr:last').after(tr);
    }


    function addRow(data, index) {

      let url = decodeURIComponent(data.url);

      // let ele = `<tr>
      //    <td scope="col">${data.date}</td>
      //    <td scope="col">${data.time}</td>
      //    <td scope="col">${data.task}</td>
      //    <td scope="col">${data.title}</td>
      //    <td scope="col">${data.email}</td>
      //    <td scope="col">${data.username}</td>
      //    <td scope="col">${data.password}</td>
      //    <td scope="col"><a class="btn-link" href="${url}" title="${url}" target="_blank">View URL</a></td>
      //  </tr>`;

      //  <td scope="col">${data.time}</td>

      let ele = `<tr>
        <td scope="col">${index + 1}</td>
        <td scope="col">${data.date}</td>
        <td scope="col">${data.task}</td>
        <td scope="col">${data.title}</td>
        <td scope="col">${data.email}</td>
        <td scope="col">${data.username}</td>
        <td scope="col">${data.password}</td>
        <td scope="col"><a class="btn-link" href="${url}" title="${url}" target="_blank">View URL</a></td>`;

      if (data.img_url && data.img_url.length > 0) {
        // console.log(data.img_url);
        ele += `<td scope="col"><a class="btn-link" href="{{url('')}}/admin/work-report/seo-task-images/${data.img_url}" title="task images" target="_blank">Task Images</a></td>`;
      } else {
        ele += `<td scope="col"></td>`;
      }

      ele += `</tr>`;

      return ele;

      // $('#data-table-work-report tr:last').after(ele);
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

      //   $('#data-table-work-report tr:last').after(ele);
    }



    // function setTableData(tbl_id, response) {

    //   //for loop
    //   response.data.forEach((ele, idx) => {

    //     let status = ele.status;

    //     if (ele.action !== 'Finished') {
    //       status = `Active`;
    //     }

    //     tbl_id.row.add(
    //       [
    //         (idx + 1),
    //         ele.date,
    //         ele.task,
    //         ele.start_time,
    //         ele.end_time,
    //         ele.total_time,
    //         status,
    //         ele.remark,
    //       ]
    //     ).draw(false);
    //   });
    //   //end for loop

    //   $("#tot_working_hours").html(response.total_working_hours);

    // }
  </script>

</body>

</html>