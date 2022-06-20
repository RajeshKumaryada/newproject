<!DOCTYPE html>
<html lang="en">

<head>

  @include('admin.template.head', ['title'=>'User Detailed Info'])

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
                <div class="card-body table-responsive">
                  <table id="active-users-tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Employee Code</th>
                        <th>Designation</th>
                        <th>Phone No.</th>
                        <th>Email</th>
                        <th>DateOfJoining</th>
                        <th>Salary</th>
                        <th>EmployementDuration</th>
                        <th>ProbationDate</th>
                        <th>ProbationDays|Month Remain</th>
                        <th>LastIncrement</th>
                        <th>NextIncrementDate</th>
                        <th>NextIncrementDays|Month Remain</th>
                        <th>Document</th>
                        <th>vaccine</th>
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

      let url = `{{url('')}}/ajax/admin/user/manage/detailed-user-info`;
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
              isAjax = false;
              $('#refresh-tbl-data').removeAttr('disabled');
              resetLoadingBtn('#refresh-tbl-data', btnText);
              }

              isAjax = false;

            },
            error: function(xhr, status) {
              ajaxErrorCalback(xhr, status)

            }
          });

        }

      });

      // $('#active-users-tbl').on('change', '#status', function() {

      //   if (!confirm('Are you sure you want to Approve')) {
      //     return;
      //   }
      //   var status = $(this).val();
      //   var id = $(this).attr('data-id');


      //   $.ajax({
      //     url: "{{url('')}}/ajax/admin/user/manage/detailed-user-info",
      //     type: 'post',
      //     data: {
      //       id: id,
      //       status: status,
      //       _token: `{{csrf_token()}}`
      //     },

      //     // contentType: false,
      //     // processData: false,
      //     success: function(res) {
      //       if (res.code == 200) {
      //         Toast.fire({
      //           icon: 'success',
      //           title: res.msg
      //         });
      //       //   if (res.msg == 'Deny') {
      //       //     $('#remark-modal-form input#id').val(res.data.id);
      //       //     $('#remark-modal').modal('show');

      //       //     // getDepList(dataTableObj);
      //       //   }
      //         getDepList(dataTableObj);
      //         getAjaxData(activeUserTbl, url, setTableData);

      //       } else if (res.code == 100) {
      //         showInvalidFields(res.err);
      //       } else {
      //         Toast.fire({
      //           icon: 'error',
      //           title: res.msg
      //         });

      //       }
      //     }
      //   });


      // });


  



      // $('#active-users-tbl').on('click', '#btn-remark', function() {
      //   var id = $(this).attr('data-rid');

      //   $.ajax({
      //     url: "{{url('')}}/ajax/admin/manage/document/user/fetch-remark",
      //     type: 'post',
      //     data: {
      //       id: id,
      //       status: status,
      //       _token: `{{csrf_token()}}`
      //     },

      //     // contentType: false,
      //     // processData: false,
      //     success: function(res) {
      //       if (res.code == 200) {
      //         // Toast.fire({
      //         //   icon: 'success',
      //         //   title: res.msg
      //         // });

      //         $('#remark-modal-view .modal-body').html(res.dataremark.remark);
      //         $('#remark-modal-view').modal('show');
      //         //getDepList(dataTableObj);
      //       } else if (res.code == 100) {
      //         showInvalidFields(res.err);
      //       } else {
      //         Toast.fire({
      //           icon: 'error',
      //           title: res.msg
      //         });

      //       }
      //     }
      //   });

      //   // $('#remark-modal-form input#id').val(id);
      //   // $('#remark-modal').modal('show');
      // });




      // $('#remark-modal-form').on('submit', function(e) {
      //   e.preventDefault();

      //   var id = $(this).attr('data-rid');

      //   $.ajax({
      //     url: "{{url('')}}/ajax/admin/manage/document/user/update",
      //     type: 'post',
      //     data: new FormData(this),
      //     contentType: false,
      //     processData: false,
      //     success: function(res) {
      //       if (res.code == 200) {
      //         Toast.fire({
      //           icon: 'success',
      //           title: res.msg
      //         });
      //         $('#remark-modal-form').trigger('reset');
      //         $('#remark-modal').modal('hide');

      //       } else if (res.code == 100) {
      //         showInvalidFields(res.err);
      //       } else {
      //         Toast.fire({
      //           icon: 'error',
      //           title: res.msg
      //         });

      //       }
      //     }
      //   });


      // });

    
    });



    function setTableData(tbl_id, response) {
      tbl_id.clear().draw();
      let count = 0;
      let actEmp = 0;

      // let activeList = Array();
      let inactiveList = Array();


      //for loop
      response.data.forEach((ele, idx) => {


        let personal_phone = ' ';

        if (ele.personal_phone == ' ') {
          personal_phone = ` `;
        }else{
          personal_phone = `${ele.personal_phone}`;
        }


        let prob_day_remain = ` `; 

        if(ele.prob_day_remain == ' ' || ele.prob_day_remain == undefined){
          prob_day_remain = ' ';
        }else{
          prob_day_remain = `${ele.prob_day_remain}`;
        }

        let prob_month_days_remain = ` `; 

          if(ele.prob_month_days_remain == '' || ele.prob_month_days_remain == undefined){
            prob_month_days_remain = ' ';
          }else{
            prob_month_days_remain = `${ele.prob_month_days_remain}`;
          }


        let prob_remain = ``;

          if(ele.prob_day_remain == ' ' || ele.prob_day_remain == undefined && ele.prob_month_days_remain == '' || ele.prob_month_days_remain == undefined){
            prob_remain = ``;
          }else{
            prob_remain =  prob_day_remain +' | '+ prob_month_days_remain;
          }

        let salary_next_inc_days = ``;

        if(ele.salary_next_inc_days === '' || ele.salary_next_inc_days == undefined){
          salary_next_inc_days = ` `;
        }else{
          salary_next_inc_days = `${ele.salary_next_inc_days}`;
        }

        let salary_next_inc_month_days = ` `;

        if(ele.salary_next_inc_month_days === '' || ele.salary_next_inc_month_days == undefined){
          salary_next_inc_month_days = ` `;
        }else{
          salary_next_inc_month_days = `${ele.salary_next_inc_month_days}`;
        }


        let salary_incs = ``;

        if(ele.salary_next_inc_month_days === '' || ele.salary_next_inc_month_days == undefined && ele.salary_next_inc_days === '' || ele.salary_next_inc_days == undefined){
          salary_incs = ` `;
        }else{
          salary_incs = salary_next_inc_days +' | '+ salary_next_inc_month_days;
        }



        let document = '';

        if(ele.document  == 1){
          document = `Yes`;
        }else{
          document = `No`;
        }

        let vaccine = '';

        if(ele.vac_dose_one == 1 &&  ele.vac_dose_two == 1){
          vaccine = `Yes`;
        }else if(ele.vac_dose_two == 1){
          vaccine = `Yes`;
        }else if(ele.vac_dose_one == 1){
          vaccine = `Only First Dose`;
        }else{
          vaccine = `No`;
        }

        tbl_id.row.add(
          [
            (++count),
            ele.users.username,
            ele.emp_code,
            ele.designation,
            ele.personal_phone,
            ele.personal_email,
            ele.date_of_joining,
            ele.salary,
            ele.emp_duration,
            ele.prob_date,
            // prob_day_remain +' | '+ prob_month_days_remain,
            prob_remain,
            ele.prob_month_days_remain,
            ele.salary_last_date,
            // salary_next_inc_days +' | '+ salary_next_inc_month_days,
            salary_incs,
            document,
            vaccine

          ]
        ).draw(false);

      });
      //end for loop

      count = 1;




    //   response.data.bank.forEach((ele, idx) => {

    //     let status_bank = "Denied";

    //     if (ele.status === 0) {
    //       status_bank = `<div class="form-group">
    //           <select class="form-control" id="status" data-id="${ele.id}" data-userDocId="${ele.user_doc_id}" name="status" >
    //           <option>Select</option>  
    //           <option value="1" ${(ele.status == 1)?'selected':''}>Approved</option>
    //             <option value="2" ${(ele.status == 2)?'selected':''}>Deny</option>              
    //           </select>
    //         </div>`;
    //     }



    //     let remark_bank = `<button class="btn btn-danger btn-small" id="btn-bank-remark" data-rid="${ele.id}">Remark</button>`;

    //     let images_passbook = `<a href="{{url('')}}/users/employee-documents/images/${ele.passbook}" data-toggle="lightbox" data-title="Passbook" data-gallery="gallery">
    //                     Link
    //                   </a>`;

    //     activeBankTbl.row.add(
    //       [
    //         (++count),
    //         images_passbook,
    //         ele.bank_name,
    //         ele.acc_no,
    //         ele.ifsc,
    //         status_bank,
    //         remark_bank

    //       ]
    //     ).draw(false);

    //   });


    //   response.data.address.forEach((ele, idx) => {

    //     let type = '';

    //     if (ele.address_type == 1) {
    //       type = 'Local Address';
    //     } else {
    //       type = 'Permanent Address';
    //     }

    //     if (ele.status == 2) {
    //       status_add = 'Denied';
    //     } else {
    //       status_add = `<div class="form-group">
    //           <select class="form-control" id="status" data-id="${ele.id}" data-addId="${ele.users_address_id}" name="status" >
    //           <option>Select</option>  
    //           <option value="1" ${(ele.status == 1)?'selected':''}>Approved</option>
    //             <option value="2" ${(ele.status == 2)?'selected':''}>Deny</option>              
    //           </select>
    //         </div>`;

    //     }




    //     let remark_add = `<button class="btn btn-danger btn-small" id="btn-address-remark" data-addId="${ele.id}">Remark</button>`;


    //     activeAddressTbl.row.add(
    //       [
    //         (++count),
    //         ele.user_name.username,
    //         type,
    //         ele.address_line_one,
    //         ele.address_line_two,
    //         ele.city,
    //         ele.state,
    //         ele.country,
    //         ele.postal_address,
    //         status_add,
    //         remark_add

    //       ]
    //     ).draw(false);

    //   });

    }
  </script>

</body>

</html>