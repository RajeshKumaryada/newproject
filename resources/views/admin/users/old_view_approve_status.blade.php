<!DOCTYPE html>
<html lang="en">

<head>

  @include('admin.template.head', ['title'=>'Approve Status'])

  <link rel="stylesheet" href="{{url('')}}/layout/plugins/ekko-lightbox/ekko-lightbox.css">
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
              <h1 class="m-0">Dashboard</h1>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->



      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-8">
                      <h3 class="card-title"></h3>
                    </div>
                    <div class="col-4 text-right">
                      <button class="btn btn-link" id="refresh-tbl-data">
                        <i class="fas fa-sync-alt"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="active-users-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Doc Verify</th>
                        <th>Doc Link</th>
                        <th>Status</th>
                        <th>Remark</th>

                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>

                <div class="card-body">
                  <table id="active-bank-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Passbook</th>
                        <th>Bank Name</th>
                        <th>A/C No.</th>
                        <th>IFSC</th>
                        <th>status</th>
                        <th>Remark</th>
                      </tr>
                    </thead>
                    <tbody></tbody>

                  </table>
                </div>

                <div class="card-body">
                  <table id="active-address-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Address Type</th>
                        <th>Address one</th>
                        <th>Address two</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Postal Address</th>
                        <th>Status</th>
                        <th>Remark</th>
                      </tr>
                    </thead>
                    <tbody></tbody>

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

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  <div class="modal fade" id="remark-modal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Remark</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form id="remark-modal-form">
          <!-- Modal body -->
          <div class="modal-body">

            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="bank_id" id="bank_id">
            <div class="form-group">
              <label for="comment">Reasons</label>
              <textarea class="form-control" rows="5" id="remark" name="remark"></textarea>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="remark-modal-address-view-reason">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Remark</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form id="remark-modal-form-address">
          <!-- Modal body -->
          <div class="modal-body">

            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="address_id" id="address_id">
            <div class="form-group">
              <label for="comment">Reasons</label>
              <textarea class="form-control" rows="5" id="remark" name="remark"></textarea>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="remark-modal-view">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Remark</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>


        <!-- Modal body -->
        <div class="modal-body" id="view-remark">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">

        </div>

      </div>
    </div>
  </div>


  <div class="modal fade" id="remark-modal-address-view">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Remark</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>


        <!-- Modal body -->
        <div class="modal-body" id="view-remark-address">

        </div>


      </div>
    </div>
  </div>




  @include('admin.template.scripts')

  <script src="{{url('')}}/layout/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

  <script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true,
        // leftArrow: `<i class='fas fa-chevron-circle-left'></i>`,
        // rightArrow: `<i class='fas fa-chevron-circle-right'></i>`
      });
    });
  </script>

  <!-- <script>
    var activeUserTbl;

    $(function() {

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });


      $("#active-users-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#active-users-tbl_wrapper .col-md-6:eq(0)');

      activeUserTbl = $("#active-users-tbl").DataTable();

      $("#active-bank-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#active-bank-tbl_wrapper .col-md-6:eq(0)');


      activeBankTbl = $("#active-bank-tbl").DataTable();

      let url = `{{url('')}}/ajax/admin/manage/document/user/get-data`;
      getAjaxData(activeUserTbl, url, setTableData);


      let isAjax = false;
      $('#refresh-tbl-data').on('click', function(e) {

        if (!isAjax) {
          isAjax = true;

          $(this).attr('disabled', 'true');
          let btnText = $(this).html();
          activeLoadingBtn("#refresh-tbl-data");

          $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {

              if (response.code === 200) {
                setTableData(activeUserTbl, response);
              }

              isAjax = false;

            },
            error: function(xhr, status) {
              ajaxErrorCalback(xhr, status)

            }
          });

        }

      });

      $('#active-users-tbl').on('change', '#status', function() {

        if (!confirm('Are you sure you want to Approve')) {
          return;
        }
        var status = $(this).val();
        var id = $(this).attr('data-id');


        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/approve",
          type: 'post',
          data: {
            id: id,
            status: status,
            _token: `{{csrf_token()}}`
          },

          // contentType: false,
          // processData: false,
          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              if (res.msg == 'Deny') {
                $('#remark-modal-form input#id').val(res.data.id);
                $('#remark-modal').modal('show');

                // getDepList(dataTableObj);
              }
              getAjaxData(activeUserTbl, url, setTableData);

            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });


      });

      $('#active-bank-tbl').on('change', '#status', function() {

        if (!confirm('Are you sure you want to Approve')) {
          return;
        }
        var status = $(this).val();
        var id = $(this).attr('data-id');


        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/approve-bank",
          type: 'post',
          data: {
            id: id,
            status: status,
            _token: `{{csrf_token()}}`
          },

          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              if (res.msg == 'Bank Info Deny') {
                $('#remark-modal-form input#bank_id').val(res.data.id);
                $('#remark-modal').modal('show');
              }
              getAjaxData(activeUserTbl, url, setTableData);

            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });


      });

      $('#active-users-tbl').on('click', '#btn-remark', function() {
        var id = $(this).attr('data-rid');

        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/fetch-remark",
          type: 'post',
          data: {
            id: id,
            status: status,
            _token: `{{csrf_token()}}`
          },

          // contentType: false,
          // processData: false,
          success: function(res) {
            if (res.code == 200) {
              // Toast.fire({
              //   icon: 'success',
              //   title: res.msg
              // });

              $('#remark-modal-view .modal-body').html(res.dataremark.remark);
              $('#remark-modal-view').modal('show');
              //getDepList(dataTableObj);
            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });

        // $('#remark-modal-form input#id').val(id);
        // $('#remark-modal').modal('show');
      });

      $('#active-bank-tbl').on('click', '#btn-bank-remark', function() {

        var bank_id = $(this).attr('data-rid');

        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/fetch-bank-remark",
          type: 'post',
          data: {
            bank_id: bank_id,
            // status: status,
            _token: `{{csrf_token()}}`
          },

          // contentType: false,
          // processData: false,
          success: function(res) {
            if (res.code == 200) {
              // Toast.fire({
              //   icon: 'success',
              //   title: res.msg
              // });

              $('#remark-modal-view .modal-body').html(res.dataremark.remark);
              $('#remark-modal-view').modal('show');
              //getDepList(dataTableObj);
            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });

        //  $('#remark-modal-form input#bank_id').val(bank_id);
        // $('#remark-modal').modal('show');
      });


      $('#remark-modal-form').on('submit', function(e) {
        e.preventDefault();

        var id = $(this).attr('data-rid');

        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/update",
          type: 'post',
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              $('#remark-modal-form').trigger('reset');
              $('#remark-modal').modal('hide');

            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });


      });


    });



    function setTableData(tbl_id, response) {
      tbl_id.clear().draw();
      activeBankTbl.clear().draw();
      let count = 0;
      let actEmp = 0;

      // let activeList = Array();
      let inactiveList = Array();


      //for loop
      response.data.doc.forEach((ele, idx) => {


        let status_doc = 'Denied';

        if (ele.status === 0) {
          status_doc = `<div class="form-group">
              <select class="form-control" id="status" data-id="${ele.id}" data-userDocId="${ele.user_doc_id}" name="status" >
              <option>Select</option>  
              <option value="1" ${(ele.status == 1)?'selected':''}>Approved</option>
                <option value="2" ${(ele.status == 2)?'selected':''}>Deny</option>              
              </select>
            </div>`;
        }



        let remark = `<button class="btn btn-danger btn-small" id="btn-remark" data-rid="${ele.id}">Remark</button>`;

        let type = '';
        if (ele.type == 'profile') {
          type = "Profile";
        } else if (ele.type == 'id_proof') {
          type = 'Id Proof';
        } else if (ele.type == '10th') {
          type = 'High School';
        } else if (ele.type == '12th') {
          type = 'Intermediate';
        } else if (ele.type == 'local_address') {
          type = 'Local Address';
        } else if (ele.type == 'permanent_address') {
          type = 'Permanent Address';
        } else if (ele.type == 'exp_certificate') {
          type = 'Experience Certificate';
        }



        let images = `<a href="{{url('')}}/users/employee-documents/images/${ele.images}" data-toggle="lightbox" data-title="${type}" data-gallery="gallery">
                        Link
                      </a>`;

        tbl_id.row.add(
          [
            (++count),
            ele.user_name.username,
            type,
            images,
            status_doc,
            remark

          ]
        ).draw(false);

      });
      //end for loop

      count = 1;




      response.data.bank.forEach((ele, idx) => {

        let status_bank = "Denied";

        if (ele.status === 0) {
          status_bank = `<div class="form-group">
              <select class="form-control" id="status" data-id="${ele.id}" data-userDocId="${ele.user_doc_id}" name="status" >
              <option>Select</option>  
              <option value="1" ${(ele.status == 1)?'selected':''}>Approved</option>
                <option value="2" ${(ele.status == 2)?'selected':''}>Deny</option>              
              </select>
            </div>`;
        }



        let remark_bank = `<button class="btn btn-danger btn-small" id="btn-bank-remark" data-rid="${ele.id}">Remark</button>`;

        let images_passbook = `<a href="{{url('')}}/users/employee-documents/images/${ele.passbook}" data-toggle="lightbox" data-title="Passbook" data-gallery="gallery">
                        Link
                      </a>`;

        activeBankTbl.row.add(
          [
            (++count),
            images_passbook,
            ele.bank_name,
            ele.acc_no,
            ele.ifsc,
            status_bank,
            remark_bank

          ]
        ).draw(false);

      });


    }
  </script> -->

  <script>
    var activeUserTbl;

    $(function() {

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });


      $("#active-users-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#active-users-tbl_wrapper .col-md-6:eq(0)');

      activeUserTbl = $("#active-users-tbl").DataTable();

      $("#active-bank-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#active-bank-tbl_wrapper .col-md-6:eq(0)');


      activeBankTbl = $("#active-bank-tbl").DataTable();

      $("#active-address-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#active-address-tbl_wrapper .col-md-6:eq(0)');


      activeAddressTbl = $("#active-address-tbl").DataTable();

      let url = `{{url('')}}/ajax/admin/manage/document/user/get-data`;
      getAjaxData(activeUserTbl, url, setTableData);
      // getAjaxAddressData(activeAddressTbl, url, setTableDataAddress);



      let isAjax = false;
      $('#refresh-tbl-data').on('click', function(e) {

        if (!isAjax) {
          isAjax = true;

          $(this).attr('disabled', 'true');
          let btnText = $(this).html();
          activeLoadingBtn("#refresh-tbl-data");

          $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {

              if (response.code === 200) {
                setTableData(activeUserTbl, response);
              }

              isAjax = false;

            },
            error: function(xhr, status) {
              ajaxErrorCalback(xhr, status)

            }
          });

        }

      });

      $('#active-users-tbl').on('change', '#status', function() {

        if (!confirm('Are you sure you want to Approve')) {
          return;
        }
        var status = $(this).val();
        var id = $(this).attr('data-id');


        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/approve",
          type: 'post',
          data: {
            id: id,
            status: status,
            _token: `{{csrf_token()}}`
          },

          // contentType: false,
          // processData: false,
          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              if (res.msg == 'Deny') {
                $('#remark-modal-form input#id').val(res.data.id);
                $('#remark-modal').modal('show');

                // getDepList(dataTableObj);
              }
              getAjaxData(activeUserTbl, url, setTableData);

            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });


      });

      $('#active-bank-tbl').on('change', '#status', function() {

        if (!confirm('Are you sure you want to Approve')) {
          return;
        }
        var status = $(this).val();
        var id = $(this).attr('data-id');


        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/approve-bank",
          type: 'post',
          data: {
            id: id,
            status: status,
            _token: `{{csrf_token()}}`
          },

          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              if (res.msg == 'Bank Info Deny') {
                $('#remark-modal-form input#bank_id').val(res.data.id);
                $('#remark-modal').modal('show');
              }
              getAjaxData(activeUserTbl, url, setTableData);

            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });


      });

      $('#active-address-tbl').on('change', '#status', function() {

        if (!confirm('Are you sure you want to Approve')) {
          return;
        }
        var status = $(this).val();
        var id = $(this).attr('data-id');
        var type_id = $(this).attr('data-addId');


        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/approve-address",
          type: 'post',
          data: {
            id: id,
            status: status,
            type_id: type_id,
            _token: `{{csrf_token()}}`
          },

          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              if (res.msg == 'Address Deny') {
                $('#remark-modal-address-view-reason input#id').val(res.data.id);
                $('#remark-modal-address-view-reason').modal('show');
              }
              getAjaxData(activeUserTbl, url, setTableData);

            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });


      });

      $('#active-users-tbl').on('click', '#btn-remark', function() {
        var id = $(this).attr('data-rid');

        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/fetch-remark",
          type: 'post',
          data: {
            id: id,
            status: status,
            _token: `{{csrf_token()}}`
          },

          // contentType: false,
          // processData: false,
          success: function(res) {
            if (res.code == 200) {
              // Toast.fire({
              //   icon: 'success',
              //   title: res.msg
              // });

              $('#remark-modal-view .modal-body').html(res.dataremark.remark);
              $('#remark-modal-view').modal('show');
              //getDepList(dataTableObj);
            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });

        // $('#remark-modal-form input#id').val(id);
        // $('#remark-modal').modal('show');
      });

      $('#active-bank-tbl').on('click', '#btn-bank-remark', function() {

        var bank_id = $(this).attr('data-rid');

        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/fetch-bank-remark",
          type: 'post',
          data: {
            bank_id: bank_id,
            // status: status,
            _token: `{{csrf_token()}}`
          },

          // contentType: false,
          // processData: false,
          success: function(res) {
            if (res.code == 200) {
              // Toast.fire({
              //   icon: 'success',
              //   title: res.msg
              // });

              $('#remark-modal-view .modal-body').html(res.dataremark.remark);
              $('#remark-modal-view').modal('show');
              //getDepList(dataTableObj);
            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });

        //  $('#remark-modal-form input#bank_id').val(bank_id);
        // $('#remark-modal').modal('show');
      });
      
      $('#active-address-tbl').on('click', '#btn-address-remark', function() {

        var add_id = $(this).attr('data-addid');

        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/fetch-address-remark",
          type: 'post',
          data: {
            add_id: add_id,
            // status: status,
            _token: `{{csrf_token()}}`
          },

          // contentType: false,
          // processData: false,
          success: function(res) {
            if (res.code == 200) {
              // Toast.fire({
              //   icon: 'success',
              //   title: res.msg
              // });

              $('#remark-modal-address-view .modal-body').html(res.dataAddremark.remark);
              $('#remark-modal-address-view').modal('show');
              //getDepList(dataTableObj);
            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });

        //  $('#remark-modal-form input#bank_id').val(bank_id);
        // $('#remark-modal').modal('show');
      });


      $('#remark-modal-form').on('submit', function(e) {
        e.preventDefault();

        var id = $(this).attr('data-rid');

        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/update",
          type: 'post',
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              $('#remark-modal-form').trigger('reset');
              $('#remark-modal').modal('hide');

            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });


      });

      $('#remark-modal-form-address').on('submit', function(e) {
        e.preventDefault();

        var id = $(this).attr('data-id');

        $.ajax({
          url: "{{url('')}}/ajax/admin/manage/document/user/update-address",
          type: 'post',
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              $('#remark-modal-address-view-reason').trigger('reset');
              $('#remark-modal-address-view-reason').modal('hide');
              window.reload();

            } else if (res.code == 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });

            }
          }
        });


      });
    });



    function setTableData(tbl_id, response) {
      tbl_id.clear().draw();
      activeBankTbl.clear().draw();
      activeAddressTbl.clear().draw();
      let count = 0;
      let actEmp = 0;

      // let activeList = Array();
      let inactiveList = Array();


      //for loop
      response.data.doc.forEach((ele, idx) => {


        let status_doc = 'Denied';

        if (ele.status === 0) {
          status_doc = `<div class="form-group">
              <select class="form-control" id="status" data-id="${ele.id}" data-userDocId="${ele.user_doc_id}" name="status" >
              <option>Select</option>  
              <option value="1" ${(ele.status == 1)?'selected':''}>Approved</option>
                <option value="2" ${(ele.status == 2)?'selected':''}>Deny</option>              
              </select>
            </div>`;
        }



        let remark = `<button class="btn btn-danger btn-small" id="btn-remark" data-rid="${ele.id}">Remark</button>`;

        let type = '';
        if (ele.type == 'profile') {
          type = "Profile";
        } else if (ele.type == 'id_proof') {
          type = 'Id Proof';
        } else if (ele.type == '10th') {
          type = 'High School';
        } else if (ele.type == '12th') {
          type = 'Intermediate';
        } else if (ele.type == 'local_address') {
          type = 'Local Address';
        } else if (ele.type == 'permanent_address') {
          type = 'Permanent Address';
        } else if (ele.type == 'exp_certificate') {
          type = 'Experience Certificate';
        }



        let images = `<a href="{{url('')}}/users/employee-documents/images/${ele.images}" data-toggle="lightbox" data-title="${type}" data-gallery="gallery">
                        Link
                      </a>`;

        tbl_id.row.add(
          [
            (++count),
            ele.user_name.username,
            type,
            images,
            status_doc,
            remark

          ]
        ).draw(false);

      });
      //end for loop

      count = 1;




      response.data.bank.forEach((ele, idx) => {

        let status_bank = "Denied";

        if (ele.status === 0) {
          status_bank = `<div class="form-group">
              <select class="form-control" id="status" data-id="${ele.id}" data-userDocId="${ele.user_doc_id}" name="status" >
              <option>Select</option>  
              <option value="1" ${(ele.status == 1)?'selected':''}>Approved</option>
                <option value="2" ${(ele.status == 2)?'selected':''}>Deny</option>              
              </select>
            </div>`;
        }



        let remark_bank = `<button class="btn btn-danger btn-small" id="btn-bank-remark" data-rid="${ele.id}">Remark</button>`;

        let images_passbook = `<a href="{{url('')}}/users/employee-documents/images/${ele.passbook}" data-toggle="lightbox" data-title="Passbook" data-gallery="gallery">
                        Link
                      </a>`;

        activeBankTbl.row.add(
          [
            (++count),
            images_passbook,
            ele.bank_name,
            ele.acc_no,
            ele.ifsc,
            status_bank,
            remark_bank

          ]
        ).draw(false);

      });


      response.data.address.forEach((ele, idx) => {

        let type = '';

        if (ele.address_type == 1) {
          type = 'Local Address';
        } else {
          type = 'Permanent Address';
        }

        if (ele.status == 2) {
          status_add = 'Denied';
        } else {
          status_add = `<div class="form-group">
              <select class="form-control" id="status" data-id="${ele.id}" data-addId="${ele.users_address_id}" name="status" >
              <option>Select</option>  
              <option value="1" ${(ele.status == 1)?'selected':''}>Approved</option>
                <option value="2" ${(ele.status == 2)?'selected':''}>Deny</option>              
              </select>
            </div>`;

        }




        let remark_add = `<button class="btn btn-danger btn-small" id="btn-address-remark" data-addId="${ele.id}">Remark</button>`;


        activeAddressTbl.row.add(
          [
            (++count),
            ele.user_name.username,
            type,
            ele.address_line_one,
            ele.address_line_two,
            ele.city,
            ele.state,
            ele.country,
            ele.postal_address,
            status_add,
            remark_add

          ]
        ).draw(false);

      });

    }
  </script>

</body>

</html>