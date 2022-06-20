<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ['title'=>'Content Writer'])
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
              <h1 class="m-0">Content Writer Work Report</h1>
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
                  <h3 class="card-title">Add New Task</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="work-start-form">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Enter Task Details</label>
                          <input type="text" name="task_details" id="task_details" class="form-control" placeholder="Enter Task Details">
                        </div>
                      </div>

                    </div>


                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="start-task-btn" class="btn btn-primary float-right">Start Task</button>
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

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="card-title">
                        Today Task Details
                      </h3>
                    </div>
                    <div class="col-md-4 text-right">
                      <strong>Today Working Hours - <span id="tot_working_hours">0h 0m 0s</span> </strong>
                      <br>
                      <span id="cw_tot_words_count"></span>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <div class="table-responsive">
                    <table id="task-info-tbl" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Date</th>
                          <th>Task</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>Total Time</th>
                          <th>Status</th>
                          <th>Word Count</th>
                          <th>File Link</th>
                          <th>Action</th>
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
                          <th>Word Count</th>
                          <th>File Link</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                </div>
                <!-- /.card-body -->
              </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>

    </div>
    <!-- /.content-wrapper -->

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->

  @include('user_template.scripts')

  <!-- Page specific script -->
  <script>
    var intervalTimer;
    var taskInfoTbl;
    $(function() {
      $("#task-info-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#task-info-tbl_wrapper .col-md-6:eq(0)');

      // bsCustomFileInput.init();

      taskInfoTbl = $("#task-info-tbl").DataTable();

      getTableInfoData(taskInfoTbl);


    });

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
          url: `{{url('')}}/ajax/content-writer/task/add`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              if(res.data != ''){
                startFunction(res.data.result);

              }

              $(formEle).trigger("reset");
              getTableInfoData(taskInfoTbl);

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
                title: "Undefined response"
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

    function getTableInfoData(taskInfoTbl) {
      taskInfoTbl.clear().draw();
      let url = `{{url('')}}/ajax/content-writer/task/list`;
      getAjaxData(taskInfoTbl, url, setTableData);

    }

    function setTableData(tbl_id, response) {

      let cw_tot_words_count = 0;
      //for loop
      response.data.forEach((ele, idx) => {


        let file_url = `<a href='${ele.file_url}' target='_blank' title='${ele.file_url}'>Visit</a>`;
        let action = ele.action;
        let status = ele.status;
        let word_count = ele.word_count;


        if (ele.action !== 'Finished') {
          file_url = `<div class="m-0 form-group"><input type="text" id="task_file_url" class="form-control w-100" placeholder="Enter file URL here.."></div>`;
          action = `<button id="task_finish_btn" class="btn btn btn-primary" value="${response.token}">Finish Task</button>
            <input type="hidden" id="finish_task_id" value="${ele.task_id}">`;
          status = `<div class="m-0 form-group"><select id="task_status" class="form-control w-100">
          <option value='1'>Completed</option>
          <option value="0">Incomplete</option>
          </select></div>`;
          word_count = `<div class="m-0 form-group"><input type="number" id="task_word_count" class="form-control w-100" placeholder="Enter word count here.."></div>`;

        } else {
          cw_tot_words_count += ele.word_count;
        }


        tbl_id.row.add(
          [
            (idx + 1),
            ele.date,
            ele.task,
            ele.start_time,
            ele.end_time,
            ele.total_time,
            status,
            word_count,
            file_url,
            action,
          ]
        ).draw(false);
      });
      //end for loop

      $('#cw_tot_words_count').html(`<strong>Total Words in a day : ${cw_tot_words_count}</strong>`);
      $("#tot_working_hours").html(response.total_working_hours);

      if (response.is_task_active === true) {
        intervalTimer = setInterval(function() {
          runActiveTaskTime(response.total_working_hours_arr, runActiveTaskTimeFormat);
        }, 1000);
      } else if (response.is_task_active === false) {

        if (intervalTimer) {
          clearTimeout(intervalTimer);
        }

      }


      let eleTaskBtn = "#task_finish_btn";
      isAjax = false;
      $(eleTaskBtn).on('click', function(e) {

        let status = $('#task_status').val();
        let task_file_url = $('#task_file_url').val();
        let task_word_count = $('#task_word_count').val();
        let task_id = $('#finish_task_id').val();
        let _token = $(eleTaskBtn).val();

        if (!isAjax) {
          isAjax = true;
          $(eleTaskBtn).attr('disabled', 'true');
          let btnText = $(eleTaskBtn).html();
          activeLoadingBtn(eleTaskBtn);

          let Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
          });

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/content-writer/task/finish`,
            data: {
              status: status,
              task_file_url: task_file_url,
              task_word_count: task_word_count,
              task_id: task_id,
              _token: _token
            },
            success: function(res) {

              if (res.code === 200) {

                Toast.fire({
                  icon: 'success',
                  title: res.msg
                });
                // endTask(res.data.id);
                getTableInfoData(taskInfoTbl);

              } else if (res.code === 100) {
                showInvalidFields(res.err);
              } else if (res.code === 101) {

                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
              } else {
                alert(res.msg);
              }

              isAjax = false;
              $(eleTaskBtn).removeAttr('disabled');
              resetLoadingBtn(eleTaskBtn, btnText);
            },
            error: function(status, res, err) {
              if (status.status === 419) {
                alert(status.responseJSON.message, status);
              }
              isAjax = false;
              $(eleTaskBtn).removeAttr('disabled');
              resetLoadingBtn(eleTaskBtn, btnText);
            }
          });
        }

      });
    }
  </script>
</body>

</html>
