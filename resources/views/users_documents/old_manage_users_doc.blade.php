<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ['title'=>''])

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
              <h1 class="m-0">Submit Document</h1>
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
                  <h3 class="card-title">Submit Documents via Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <form id="form-submit-doc" method="POST" enctype="multipart/form-data">
                  <div class="card-body">


                    <div class="row">

                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <div class="form-group">
                              <label for="usr">Profile:</label>
                              <input type="file" class="form-control" id="profile" name="profile">
                            </div>
                          </div>



                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="idproof">Id Proof:</label>
                              <input type="file" class="form-control" id="id_proof" name="id_proof">
                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="add">Permanent Address:</label>
                              <input type="file" class="form-control" id="permanent_address" name="permanent_address">
                            </div>
                          </div>


                          <div class="col-md-6">

                            <div class="form-group">
                              <label for="add">Local address:</label>
                              <input type="file" class="form-control" id="local_address" name="local_address">
                            </div>
                          </div>
                        </div>



                        <h6> <label for="add">Educational Certificate:</label></h6>
                        <div>
                          <div class="row form-row form-row-container temp-form-row">
                            <div class="col-md-4">
                              <div class="form-group input-group">

                                <input class="form-control text-input" type="file" name="images[]" />
                              </div>

                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <select class="form-control" id="educ[]" name="educ[]">
                                  <option value="">--Select--</option>
                                  <option value="high_school">High School</option>
                                  <option value="inter">Intermediate</option>
                                  <option value="grad">Graduation</option>
                                  <option value="post_grad">Post Graduation</option>
                                </select>
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

                        <div class="d-none" id="form-row-copy">
                          <div class="row form-row form-row-container temp-form-row">
                            <div class="col-md-4">
                              <div class="form-group input-group">

                                <input class="form-control text-input" type="file" name="images[]" />
                              </div>

                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <select class="form-control" id="educ[]" name="educ[]">
                                  <option value="">--Select--</option>
                                  <option value="10th">High School</option>
                                  <option value="12th">Intermediate</option>
                                  <option value="grad">Graduation</option>
                                  <option value="post_grad">Post Graduation</option>
                                </select>
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


                        <div id="init-row">
                          <div class="row form-row form-row-container">

                          </div>
                        </div>


                        <div class="row">
                          <div class="col-md-12">
                            <div id="add-row-btn" class="text-center">
                              <span class="btn btn-link add-row-btn">
                                <i class="fas fa-plus"></i> Add Row
                              </span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="add">Experience Certificate:</label>
                          <input type="file" class="form-control" id="exp_certificate" name="exp_certificate">
                        </div>

                      </div>


                    </div>
                  </div>
                  <!-- /.card-body -->


              </div>
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Bank Details:</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->


                <div class="card-body">


                  <div class="row">


                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="usr">Passbook:</label>
                        <input type="file" class="form-control" id="passbook" name="passbook">
                      </div>
                    </div>


                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="idproof">Bank name:</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name">
                      </div>
                    </div>


                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="add">Account Number:</label>
                        <input type="text" class="form-control" id="acc_no" name="acc_no" placeholder="Enter A/C No.">
                      </div>
                    </div>


                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="add">IFSC Code:</label>
                        <input type="text" class="form-control" id="ifsc" name="ifsc" placeholder="Enter IFSC Code">
                      </div>


                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">

                    <button type="submit" id="form-sub-btn" class="btn btn-primary float-right">Submit</button>

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



    </div>


    @include('user_template.footer')


  </div>


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

    });


    let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });


    isAjax = false;
    $('form#form-submit-doc').submit(function(e) {
      e.preventDefault();


      
      if (!isAjax) {

        isAjax = true;
        let frmBtn = "#form-sub-btn";
        let btnText = $(frmBtn).html();
        $(frmBtn).attr('disabled', 'true');
        activeLoadingBtn(frmBtn);

        $.ajax({
          type: 'POST',
          url: `{{url('')}}/users/employee-documents/add`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {

              $('form#form-submit-doc').trigger("reset");
              Toast.fire({
                icon: 'success',
                title: res.msg
              });

              window.location.href = `{{ url("") }}/404.php`;


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



    // function setTableData(tbl_id, response) {

    //   let rows = [];

    //   //for loop
    //   response.data.forEach((ele, idx) => {

    //     tblRowCount += 1;




    //     // console.log(tbl_id.row);
    //     if (ele.seo_task_list.task == 'Other' || ele.task_id == 36) {
    //       console.log(ele.task_id);
    //       rows = [
    //         (tblRowCount),
    //         ele.date,
    //         ele.seo_task_list.task,
    //         ele.title,
    //       ];
    //       // console.log(tbl_id.row);

    //       // $(`tr:nth-child(${8})  td:eq(3)`).attr('colspan', 5);
    //       tbl_id.row.add(
    //         rows
    //       ).draw();




    //     } else {
    //       rows = [
    //         (tblRowCount),
    //         ele.date,
    //         ele.seo_task_list.task,
    //         ele.title,
    //         ele.email,
    //         ele.username,
    //         ele.password,
    //         decodeURIComponent(ele.url)
    //       ];

    //       tbl_id.row.add(
    //         rows
    //       ).draw();
    //     }

    //     // tbl_id.row.add(
    //     //   rows
    //     // ).draw();

    // });
    //   //end for loop
  </script>
</body>

</html>