<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ['title'=>'Work Report of '. AppSession::get()->userName()])

  <style>
    .clear-btn {
      cursor: pointer;
    }
  </style>
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
              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Submit Work Report via Excelsheet</h3>
                </div>
                <!-- /.card-header -->



                <div class="card-body">


                  <div class="row">

                    <div class="col-md-12">

                      <div class="row">
                        <div class="col-md-10">
                          <strong>You may submit Work-Report from Excelsheet <a href="{{url('')}}/downloads/work_report_sheet.xlsx" target="_blank" rel="noopener noreferrer">(Download Excelsheet here)</a>
                            OR you may submit report via HTML form. If you don't have MS Office, please <a href="https://docs.google.com/spreadsheets/d/1vYkzcmx69v-vkBB3m4_YMwVN8PtgZI1LfSRF6ewmmTo/edit?usp=sharing" target="_blank" rel="noopener noreferrer">View Format</a> and prepare by yourself at Google Sheet.</strong>
                        </div>
                        <div class="col-md-2 text-right">
                          <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#form-excel-submit" aria-expanded="true" aria-controls="form-excel-submit">Import from Excelsheet</button>
                        </div>

                      </div>
                      <div class="row">

                        <div class="col-sm-12">
                          <form class="mt-4 collapse" id="form-excel-submit" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Select Task</label>
                                  <select name="task_excel" id="task_excel" class="form-control w-100" required>
                                    <option value="">-- Select --</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label><strong>Select File (.xls , .xlsx):</strong></label>
                                  <input type="file" class="form-control" id="efile" name="efile" accept=".xls,.xlsx" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group text-right">
                                  <button type="submit" name="Submit" id="import-excel-btn" class="btn btn-success">Import</button>
                                </div>
                              </div>

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


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Submit Work Report via Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <form id="form-submit" method="POST" enctype="multipart/form-data">
                  <div class="card-body">


                    <div class="row">

                      <div class="col-md-12">


                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group">
                          <label for="exampleInputEmail1">Select Task</label>
                          <select name="task_details" id="task_details" class="form-control w-100" required>
                            <option value="">-- Select --</option>
                          </select>
                        </div>

                        <div id="init-row">
                          <div class="row form-row form-row-container">
                            <div class="col-md-2">
                              <div class="form-group input-group">
                                <input class="form-control text-input" type="text" name="title[]" required placeholder="Title" />
                                <div class="input-group-append cur-pointer" id="generate-password">
                                  <span class="input-group-text clear-btn">x</span>
                                </div>

                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group input-group">
                                <input class="form-control text-input" type="Email" name="email[]" placeholder="Email" />
                                <div class="input-group-append cur-pointer" id="generate-password">
                                  <span class="input-group-text clear-btn">x</span>
                                </div>

                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group input-group">
                                <input class="form-control text-input" type="text" name="username[]" placeholder="Username" />
                                <div class="input-group-append cur-pointer" id="generate-password">
                                  <span class="input-group-text clear-btn">x</span>
                                </div>

                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group input-group">
                                <input class="form-control text-input" type="text" name="password[]" placeholder="Password" />
                                <div class="input-group-append cur-pointer" id="generate-password">
                                  <span class="input-group-text clear-btn">x</span>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group input-group">
                                <input class="form-control text-input" type="url" name="url[]" required placeholder="URL" />
                                <div class="input-group-append cur-pointer" id="generate-password">
                                  <span class="input-group-text clear-btn">x</span>
                                </div>

                              </div>
                            </div>
                            <div class="col-md-1">
                              <div class="form-group">
                                <span class="btn btn-link add-row-btn">
                                  <i class="fas fa-plus"></i> Add Row
                                </span>
                              </div>
                            </div>


                          </div>
                        </div>

                        <div class="row">

                          <div class="col-md-12 form-group d-none" id="screenshots-div">
                            <label><strong>Upload Screenshots:</strong></label>
                            <input type="file" multiple="true" class="form-control" id="screenshots" name="screenshots[]" accept=".jpg,.jpeg,.png" required disabled>
                          </div>

                          <div class="col-md-12 form-group">
                            <textarea name="ohter_task_text" id="ohter_task_text" class="form-control d-none" placeholder="Describe your work" required disabled></textarea>
                          </div>
                          <div class="col-md-12">
                            <div id="add-row-btn" class="text-center">
                              <span class="btn btn-link add-row-btn">
                                <i class="fas fa-plus"></i> Add Row
                              </span>
                            </div>
                          </div>
                        </div>



                      </div>


                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">

                    <button type="submit" id="form-sub-btn" class="btn btn-primary float-right">Submit</button>

                  </div>
                </form>



                <div class="d-none" id="form-row-copy">
                  <div class="row form-row form-row-container temp-form-row">
                    <div class="col-md-2">
                      <div class="form-group input-group">
                        <input class="form-control text-input" type="text" name="title[]" required placeholder="Title" />
                        <div class="input-group-append cur-pointer" id="generate-password">
                          <span class="input-group-text clear-btn">x</span>
                        </div>

                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group input-group">
                        <input class="form-control text-input" type="Email" name="email[]" placeholder="Email" />
                        <div class="input-group-append cur-pointer" id="generate-password">
                          <span class="input-group-text clear-btn">x</span>
                        </div>

                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group input-group">
                        <input class="form-control text-input" type="text" name="username[]" placeholder="Username" />
                        <div class="input-group-append cur-pointer" id="generate-password">
                          <span class="input-group-text clear-btn">x</span>
                        </div>

                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group input-group">
                        <input class="form-control text-input" type="text" name="password[]" placeholder="Password" />
                        <div class="input-group-append cur-pointer" id="generate-password">
                          <span class="input-group-text clear-btn">x</span>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group input-group">
                        <input class="form-control text-input" type="url" name="url[]" required placeholder="URL" />
                        <div class="input-group-append cur-pointer" id="generate-password">
                          <span class="input-group-text clear-btn">x</span>
                        </div>

                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                        <span class="btn btn-link remove-row-btn">
                          <i class="fas fa-minus"></i> Remove
                        </span>
                      </div>
                    </div>
                  </div>

                </div>


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
                      <h3 class="card-title">Submitted Work Report Info</h3>
                    </div>
                    <div class="col-md-4 text-right"></div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="task-info-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Task</th>
                        <th>Title</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>URL</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Task</th>
                        <th>Title</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>URL</th>
                      </tr>
                    </tfoot>
                  </table>
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
    var taskInfoTbl;
    var tblRowCount = 0;

    let isAjax = false;

    $(function() {


      $(".add-row-btn").on('click', function(e) {
        let clone = $('#form-row-copy > .form-row-container').clone();
        $("#init-row").append(clone);
      });
      $('#init-row').on('click', '.clear-btn', function() {
        // $($(this).siblings('input.text-input')).val("");
        $($(this).parent().siblings('input.text-input')).val("");
      });
      $('#init-row').on('click', '.remove-row-btn', function() {
        $($(this).parent().parent().parent('div.form-row-container')).remove();
      });


      $("#task-info-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#task-info-tbl_wrapper .col-md-6:eq(0)');


      taskInfoTbl = $("#task-info-tbl").DataTable();


      getWorkReportData(taskInfoTbl);

      getSeoTaskListData('#task_details');


      $('#task_details').on('change', function() {
        //alert(this.value);
        let val = this.value;

        switch (val) {
          case '36':
            showOtherTaskInput();
            // $('#ohter_task_text').removeClass('d-none');
            // $('#ohter_task_text').removeAttr('disabled');

            // $('.text-input').attr('disabled', 'disabled');
            // $('#add-row-btn').hide();
            // $('#init-row').hide();

            hideTextInputs();
            hideScreenshots();
            break;

          case '33':
            // $('#screenshots').removeClass('d-none');
            // $('#screenshots').removeAttr('disabled');

            showTextInputs();
            hideOtherTaskInput();
            // $('#ohter_task_text').attr('disabled', 'disabled');
            // $('#ohter_task_text').addClass('d-none');

            showScreenshots();
            break;

          default:
            // $('.text-input').removeAttr('disabled');
            // $('#add-row-btn').show();
            // $('#init-row').show();
            showTextInputs();

            // $('#ohter_task_text').attr('disabled', 'disabled');
            // $('#ohter_task_text').addClass('d-none');

            hideOtherTaskInput();
            hideScreenshots();
            break;
        }





      });
    });


    function showOtherTaskInput() {
      $('#ohter_task_text').removeClass('d-none');
      $('#ohter_task_text').removeAttr('disabled');
    }

    function hideOtherTaskInput() {
      $('#ohter_task_text').attr('disabled', 'disabled');
      $('#ohter_task_text').addClass('d-none');
    }


    function showTextInputs() {
      $('.text-input').removeAttr('disabled');
      $('#add-row-btn').show();
      $('#init-row').show();
    }

    function hideTextInputs() {
      $('.text-input').attr('disabled', 'disabled');
      $('#add-row-btn').hide();
      $('#init-row').hide();
    }

    function showScreenshots() {
      $('#screenshots-div').removeClass('d-none');
      $('#screenshots').removeAttr('disabled');
    }

    function hideScreenshots() {
      $('#screenshots').attr('disabled', 'disabled');
      $('#screenshots-div').addClass('d-none');
    }


    function getWorkReportData(ele_id) {
      let url = `{{url('')}}/ajax/seo/fetch-work-report`;
      getAjaxData(ele_id, url, setTableData);
    }


    function getSeoTaskListData(ele_id) {
      // taskInfoTbl.clear().draw();
      let url = `{{url('')}}/ajax/seo/seo-task-list`;
      getAjaxData(ele_id, url, _appendTaskCallback);
    }


    function _appendTaskCallback(eleId, data) {

      data.data.forEach((ele) => {
        let opt = document.createElement('option');
        let opt2 = document.createElement('option');

        opt.setAttribute('value', ele.id);
        opt.innerHTML = ele.value;

        opt2.setAttribute('value', ele.id);
        opt2.innerHTML = ele.value;

        $(eleId).append(opt);
        $('#task_excel').append(opt2);
      });
    }


    isAjax = false;
    $('form#form-excel-submit').submit(function(e) {
      e.preventDefault();

      let task = $('#form-excel-submit select').find(":selected").val();
      let file = $("#form-excel-submit input[type=file]").val();


      if (task === null || task === undefined || task === '') {
        alert("Please select a task");
        $('#form-excel-submit select').focus();
        return;
      } else if (file === null || file === undefined || file === '') {
        alert("Please select a file");
        $('#form-excel-submit input[type=file]').focus();
        return;
      }

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      if (!isAjax) {

        isAjax = true;
        let frmBtn = "#import-excel-btn";
        let btnText = $(frmBtn).html();
        $(frmBtn).attr('disabled', 'true');
        activeLoadingBtn(frmBtn);

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/submit-work-report-excel`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              setTableData(taskInfoTbl, res);
              $('form#form-excel-submit').trigger("reset");
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              if (typeof res.is_duplicate === 'object' && Object.keys(res.is_duplicate).length !== 0) {
                alert("Hay, we found some duplicate URLs in your work report. Please justify it.");
                window.open(`{{url('')}}/seo/submit-work-report/url-answer`, "_self");
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



    isAjax = false;
    $('form#form-submit').submit(function(e) {
      e.preventDefault();

      let task = $('#form-submit select').find(":selected").val();
      let file = $("#form-submit input[type=file]").val();


      if (task === null || task === undefined || task === '') {
        alert("Please select a task");
        $('#form-submit select').focus();
        return;
      }
      // else if (file === null || file === undefined || file === '') {
      //   alert("Please select a file");
      //   $('#form-submit input[type=file]').focus();
      //   return;
      // }

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      if (!isAjax) {

        isAjax = true;
        let frmBtn = "#form-sub-btn";
        let btnText = $(frmBtn).html();
        $(frmBtn).attr('disabled', 'true');
        activeLoadingBtn(frmBtn);

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/submit-work-report`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              setTableData(taskInfoTbl, res);
              $('form#form-submit').trigger("reset");
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              if (typeof res.is_duplicate === 'object' && Object.keys(res.is_duplicate).length !== 0) {
                alert("Hay, we found some duplicate URLs in your work report. Please justify it.");
                window.open(`{{url('')}}/seo/submit-work-report/url-answer`, "_self");
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



    function setTableData(tbl_id, response) {

      let rows = [];

      //for loop
      response.data.forEach((ele, idx) => {

        tblRowCount += 1;




        // console.log(tbl_id.row);
        if (ele.seo_task_list.task == 'Other' || ele.task_id == 36) {
          console.log(ele.task_id);
          rows = [
            (tblRowCount),
            ele.date,
            ele.seo_task_list.task,
            '',
            '',
            '',
            '',
            ele.title,
          ];
          // console.log(tbl_id.row);

          // $(`tr:nth-child(${8})  td:eq(3)`).attr('colspan', 5);
          tbl_id.row.add(
            rows
          ).draw();




        } else {
          rows = [
            (tblRowCount),
            ele.date,
            ele.seo_task_list.task,
            ele.title,
            ele.email,
            ele.username,
            ele.password,
            decodeURIComponent(ele.url)
          ];

          tbl_id.row.add(
            rows
          ).draw();
        }

        // tbl_id.row.add(
        //   rows
        // ).draw();

      });
      //end for loop



    }
  </script>
</body>

</html>