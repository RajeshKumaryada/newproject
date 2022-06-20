<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ["title"=>"SEO Link Report (Count)"])

  <style>
    .more-info-td {
      max-height: 600px;
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
              <h1 class="m-0">SEO Link Report (Count)</h1>
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
                  <h3 class="card-title">SEO Link Report (Count)</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">

                  <div class="row">

                    <div class="col-md-12 mb-2">
                      <form id="seo-work-report-form">

                        <div class="row">

                          <input type="hidden" name="_token" value="{{csrf_token()}}">

                          <div class="col-md-2">
                            <div class="form-group">
                              <label>Start Date</label>
                              <input type="date" name="start_date" id="start_date" value="{{date('Y-m-d')}}" class="form-control" placeholder="Enter ...">
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
                              <th scope="col">Menu</th>
                              <th scope="col">User Name</th>
                              <th scope="col">Total Number of Links</th>
                              <th scope="col">Research Links Present</th>
                              <th scope="col">No of Research Links</th>
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

        $("#data-table-work-report").find("tr:gt(0)").remove();

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/ajax/seo/work-report/link-count`,
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


      $('#data-table-work-report').on('click', '.links-more-info', function() {

        $(this).attr('disabled', 'true');
        let btnText = $(this).html();
        activeLoadingBtn(this);

        if (!isAjax) {
          isAjax = true;

          let targetEle = $(this).attr('data-tarele');

          $(`#${targetEle}`).html('');

          let Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
          });

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/seo/work-report/link-details`,
            data: {
              _token: $('#csrf_token_ajax').val(),
              date: $(this).attr('data-date'),
              user_id: $(this).attr('data-user')
            },
            // contentType: false,
            // processData: false,
            success: (res) => {

              if (res.code === 200) {



                setTableDataMore(targetEle, res);


                resetLoadingBtn(this, btnText);

                $(this).siblings('button.links-hide-info').removeClass('d-none');
                $(this).addClass('d-none');

              } else if (res.code === 100) {
                resetLoadingBtn(this, btnText);
              } else {
                Toast.fire({
                  icon: 'error',
                  title: res.msg
                });
                resetLoadingBtn(this, btnText);
              }

              isAjax = false;
              $(this).removeAttr('disabled');

            },
            error: (xhr, status, err) => {
              ajaxErrorCalback(xhr, status, err);
              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            }
          });

        }
      });

      $('#data-table-work-report').on('click', '.links-hide-info', function() {
        let targetEle = $(this).attr('data-tarele');

        $(`#${targetEle}`).html('');
        $(`#${targetEle}`).addClass('d-none');
        $(this).addClass('d-none');
        $(this).siblings('button.links-more-info').removeClass('d-none');
      });
    }

    function setTableDataMore(ele, response) {
      let tableEle = `<table class="table">
      <thead>
      <tr>
      <th>SN</th>
      <th>Task Name</th>
      <th>No. of Links</th>
      </tr>
      </thead>
      <tbody>`;

      let idx = 0;
      for (const [key, value] of Object.entries(response.data_task_links)) {
        tableEle += `<tr>
            <td><span class="text-danger">${++idx}</span></td>
            <td scope="col">${value.task_name}</td>
            <td scope="col">${value.task_count}</td>
            </tr>`;
      }


      tableEle += `</tbody></table>`;


      tableEle += `<table class="table">
          <thead>
          <tr>
          <th scope="col">S.N.</th>
            <th scope="col">Task</th>
            <th scope="col">Title</th>
            <th scope="col">Email</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">URL</th>
          </tr>
          </thead>
          <tbody>`;

      response.data.forEach((row, idx) => {
        let url = decodeURIComponent(row.url);
        // console.log(row, idx);
        tableEle += `<tr>
            <td><span class="text-danger">${idx + 1}</span></td>
            <td scope="col">${row.task_name}</td>
            <td scope="col">${row.title}</td>
            <td scope="col">${(row.email !== null)?row.email:''}</td>
            <td scope="col">${(row.username !== null)?row.username:''}</td>
            <td scope="col">${(row.password !== null)?row.password:''}</td>
            <td scope="col"><a target="_blank" href="${url}" title="${url}">Open URL</a></td>
            </tr>`;
      });

      tableEle += `</tbody></table>`;

      $(`#${ele}`).html(tableEle);
      $(`#${ele}`).removeClass('d-none');


    }


    function addUserInfoRow(data, index) {

      let has_research_links = "NO";
      let moreInfoBtn = `<button class="btn btn-sm btn-secondary links-more-info" disabled="true">More Details</button>`;

      if (data.total_research_links > 0)
        has_research_links = "YES";


      if (data.total_task >= 1)
        moreInfoBtn = `<button class="btn btn-sm btn-danger links-more-info" data-tarele="target_${index}" data-user="${data.user_id}" data-date="${data.date}">More Details</button>
            <button class="btn btn-sm btn-danger links-hide-info d-none" data-tarele="target_${index}">Hide Details</button>`;

      let ele = `<tr class="cur-pointer">
          <td scope="col" style="width: 3%;">
           <span>${index + 1}</span>
          </td>
          <td class="text-center">${moreInfoBtn}</td>
          <td scope="col">${data.username}</td>
          <td scope="col">${data.total_task}</td>
          <td scope="col">${has_research_links}</td>
          <td scope="col">${data.total_research_links}</td>
        </tr>
        <tr>
        <td colspan="6" id="target_${index}" class="d-none p-0 more-info-td"></td>
        </tr>
        `;
      $('#data-table-work-report .parent-table-tbody').append(ele);
    }
  </script>

</body>

</html>