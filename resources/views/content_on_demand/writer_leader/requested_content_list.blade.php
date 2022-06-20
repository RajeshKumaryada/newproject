<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ["title"=>"Writer Leader - Requested Content List By SEOs"])
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
              <h1 class="m-0">Requested Content List By SEOs</h1>
            </div>
          </div>
        </div>
      </div>


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="card-title">List</h3>
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                  </div>
                </div>


                <div class="card-body">
                  <table id="data-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Requested By</th>
                        <th>Req. Date</th>
                        <th>Assigned To</th>
                        <th>Ass. Date</th>
                        <th>Status</th>
                        <th>Title</th>
                        <th>WC</th>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Preview</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>


              </div>

            </div>

          </div>

        </div>

      </section>


    </div>
    <!-- /.content-wrapper -->

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->


  <div class="modal fade" id="data-modal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Content Description</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  <div class="modal fade" id="remarks-modal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Content Remarks</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  @include('user_template.scripts')
  <script>
    var dataTbl;
    let isAjax = false;

    var toastAlert = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });


    $(function() {

      $("#data-tbl").DataTable({
        columnDefs: [{
          bSortable: false,
          targets: [1]
        }],
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#data-tbl_wrapper .col-md-6:eq(0)');


      dataTbl = $("#data-tbl").DataTable();

      getContentList();

      $('#data-tbl').on('click', '.message-btn', function() {
        let val = $(this).parent('span').siblings("span.message").html();
        $("#data-modal").modal("show");
        $("#data-modal").on('shown.bs.modal', function() {
          $("#data-modal .modal-body p").html(val);
        });
        $("#data-modal").on('hidden.bs.modal', function() {
          $("#data-modal .modal-body p").html('');
        });
      });



      $('#data-tbl').on('click', '.remarks-btn', function() {
        let val = $(this).val();

        if (!isAjax) {
          isAjax = true;

          $(this).attr('disabled', 'true');
          let btnText = $(this).html();
          activeLoadingBtn2(this, btnText);

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/content-writer/request/content/list/get-remarks`,
            data: {
              _token: $('#csrf_token_ajax').val(),
              id: val
            },
            // contentType: false,
            // processData: false,
            success: (res) => {

              if (res.code === 200) {
                setRemarks2Modal(res.data);
              } else {
                toastAlert.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            },
            error: (status, res, err) => {
              if (status.status === 419) {
                alert(status.responseJSON.message, status);
              } else {
                ajaxErrorCalback(status, res, err);
              }

              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            }
          });

        }


      });



      //approve content request
      $('#data-tbl').on('click', '.approve-content', function() {


        if (!confirm("Are you sure to Approve ?")) {
          return;
        }

        let val = $(this).val();

        if (!isAjax) {
          isAjax = true;

          $(this).attr('disabled', 'true');
          let btnText = $(this).html();
          activeLoadingBtn2(this, btnText);

          $.ajax({
            type: 'POST',
            url: `{{url('')}}/ajax/content-writer/request/content/list/approve`,
            data: {
              _token: $('#csrf_token_ajax').val(),
              id: val
            },
            // contentType: false,
            // processData: false,
            success: (res) => {

              if (res.code === 200) {
                toastAlert.fire({
                  icon: 'success',
                  title: res.msg
                });

                getContentList();
              } else {
                toastAlert.fire({
                  icon: 'error',
                  title: res.msg
                });
              }

              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            },
            error: (status, res, err) => {
              if (status.status === 419) {
                alert(status.responseJSON.message, status);
              } else {
                ajaxErrorCalback(status, res, err);
              }

              isAjax = false;
              $(this).removeAttr('disabled');
              resetLoadingBtn(this, btnText);
            }
          });
        }
      });


    });


    function getContentList() {
      dataTbl.clear().draw();
      let url = `{{url('')}}/ajax/content-writer/request/content/list`;
      getAjaxData(dataTbl, url, setTableData);
    }


    function setTableData(tbl_id, response) {

      let count = 0;

      //for loop
      response.data.forEach((ele, idx) => {

        let menuEle = `<div class="btn-group text-center">
            <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-bars"></i> &nbsp;
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" href="{{url('')}}/content-writer/request/content/${ele.id}/assign">
                <i class="fas fa-user"></i> Assign</a>
              <button class="dropdown-item btn btn-sm btn-link text-danger approve-content" value="${ele.id}">
                <i class="fas fa-check-double"></i> Approve
              </button>
            </div>
          </div>`;


        let message = `<span><button class="btn btn-sm btn-link message-btn">
                        View 
                      </button></span>
                      <span class="message d-none">${n2br(ele.description)}</span>
                      `;


        let remarks = `<span><button class="btn btn-sm btn-link remarks-btn" value='${ele.id}'>
                        View 
                      </button></span>
                      `;


        let assignTo = '';

        if (ele.assign_to_user !== null) {
          assignTo = `${ele.assign_to_user.username} - ${ele.assign_to_user.email}`;
        }


        let contentPreview = '';

        if (ele.status >= 3) {
          contentPreview = `<a href="{{url('')}}/content-writer/request/content/${ele.id}/preview" target="_blank">Preview</a>`;
        }


        tbl_id.row.add(
          [
            (++count),
            menuEle,
            `${ele.request_by_user.username} - ${ele.request_by_user.email}`,
            ele.request_date,
            assignTo,
            (ele.assign_date == null) ? '' : ele.assign_date,
            ele.status_str,
            ele.title,
            ele.word_count,
            message,
            remarks,
            contentPreview
          ]
        ).draw(false);

      });
      //end for loop
    }


    // $('#data-tbl').on('click', '.edit-description', function() {
    //   let id = $(this).val();

    //   if (!confirm('Are you sure to edit?')) {
    //     return;
    //   }

    //   window.open(`{{url('')}}/content-writer/request/content/${id}/assign`, '_self');
    // });
  </script>

</body>

</html>