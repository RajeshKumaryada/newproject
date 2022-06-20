<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Edit User Personal Info"])
  <style>
    .height-img {
      height: 250px;
      max-height: 250px;
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
              <!-- <h1 class="m-0"></h1> -->


              <div class="card" style="width: 400px">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><strong>Username: </strong> {{$user->username}}</li>
                  <li class="list-group-item"><strong>Department: </strong> {{$user->department()->first()->dep_name}}</li>
                  <li class="list-group-item"><strong>Post: </strong> {{$user->post()->first()->post_name}}</li>
                  <li class="list-group-item"><strong>Designation: </strong> {{$user->designation()->first()->des_name}}</li>
                </ul>
              </div>

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
                  <h3 class="card-title">Edit User Personal Info</h3>
                </div>
                <!-- /.card-header -->

                <form id="edit-user-form">
                  <div class="card-body">
                    <div class="row">

                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                      <input type="hidden" name="user_id" value="{{$user->user_id}}">

                      @if(!empty($user->usersInfo()->first()))

                      <input type="hidden" id="user_info_url" value="{{url('')}}/ajax/admin/user/manage/edit/user-info-update">
                      <input type="hidden" name="user_info_id" value="{{$user->usersInfo()->first()->id}}">

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Employee Code</label>
                          <input type="text" name="emp_code" id="emp_code" value="{{$user->usersInfo()->first()->emp_code}}" class="form-control up-case" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="first_name" id="first_name" value="{{$user->usersInfo()->first()->first_name}}" class="form-control cap-case" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Middle Name</label>
                          <input type="text" name="middle_name" id="middle_name" value="{{$user->usersInfo()->first()->middle_name}}" class="form-control cap-case" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="last_name" id="last_name" value="{{$user->usersInfo()->first()->last_name}}" class="form-control cap-case" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Personal Email</label>
                          <input type="email" name="user_email" value="{{$user->usersInfo()->first()->personal_email}}" id="user_email" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Work Phone</label>
                          <input type="text" name="work_phone" value="{{$user->usersInfo()->first()->work_phone}}" id="work_phone" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Personal Phone (Optional)</label>
                          <input type="text" name="personal_phone" value="{{$user->usersInfo()->first()->personal_phone}}" id="personal_phone" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Gender</label>
                          <input type="hidden" id="user_gender" value="{{$user->gender}}">
                          <select class="form-control" name="gender" id="gender" style="width: 100%;">
                            <option value="">--Select--</option>
                            <option value="m" {{($user->usersInfo()->first()->gender == 'm')?'selected':''}}>Male</option>
                            <option value="f" {{($user->usersInfo()->first()->gender == 'f')?'selected':''}}>Female</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Date of Joining</label>
                          <input type="date" name="doj" id="doj" value="{{$user->usersInfo()->first()->date_of_joining}}" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Date of Relieving</label>
                          <input type="date" name="dor" id="dor" value="{{$user->usersInfo()->first()->date_of_relieving}}" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      @else

                      <input type="hidden" id="user_info_url" value="{{url('')}}/ajax/admin/user/manage/edit/user-info-insert">

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Employee Code</label>
                          <input type="text" name="emp_code" id="emp_code" class="form-control up-case" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="first_name" id="first_name" class="form-control cap-case" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Middle Name</label>
                          <input type="text" name="middle_name" id="middle_name" class="form-control cap-case" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="last_name" id="last_name" class="form-control cap-case" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Personal Email</label>
                          <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Work Phone</label>
                          <input type="text" name="work_phone" id="work_phone" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Personal Phone (Optional)</label>
                          <input type="text" name="personal_phone" id="personal_phone" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Gender</label>
                          <select class="form-control" name="gender" id="gender" style="width: 100%;">
                            <option value="">--Select--</option>
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Date of Joining</label>
                          <input type="date" name="doj" id="doj" class="form-control" placeholder="Enter ...">
                        </div>
                      </div>
                      @endif



                    </div>

                  </div>

                  <div class="card-footer">
                    <button type="submit" id="frm-submit-btn" class="btn btn-danger float-right">Update</button>
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
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Bank Details of User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->


                @if(empty($userInfo))

                <form id="formBankInfo">
                  @csrf
                  <div class="card-body">

                    <div class="row">

                      <input type="hidden" name="user_id" value="{{ $userId }}">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Bank Name</label>
                          <input type="text" name="bank_name" id="bank_name" class="form-control" value="" placeholder="Enter Bank Name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Account Number</label>
                          <input type="text" name="acc_no" id="acc_no" class="form-control" value="" placeholder="Enter A/C No.">
                        </div>
                      </div>


                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter IFSC Code</label>
                          <input type="text" name="ifsc" id="ifsc" class="form-control" value="" placeholder="Enter IFSC">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status" id="status">
                            <option value="1">Active</option>
                            <option value="2">Not Active</option>
                          </select>
                        </div>
                      </div>

                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Add Bank Info</button>
                  </div>
                </form>


                @else


                <form id="formBankInfoUpdate">
                  @csrf
                  <div class="card-body">

                    <div class="row">
                      <input type="hidden" name="pid" value="{{$userInfo->id}}">
                      <!-- <input type="hidden" name="user_id" value="{{$userId}}"> -->

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Bank Name</label>
                          <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ $userInfo->bank_name }}" placeholder="Enter Message">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Account Number</label>
                          <input type="text" name="acc_no" id="acc_no" class="form-control" value="{{ $userInfo->acc_no }}" placeholder="Enter Message">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter IFSC Code</label>
                          <input type="text" name="ifsc" id="ifsc" class="form-control" value="{{ $userInfo->ifsc }}" placeholder="Enter Message">
                        </div>
                      </div>
                    </div>

                    <div class="row">



                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control" name="status" id="status">
                            <option value="1" @php echo(($userInfo->status=== 1)?'selected':''); @endphp >Active</option>
                            <option value="2" @php echo(($userInfo->status=== 2)?'selected':''); @endphp>Not Active</option>
                          </select>
                        </div>
                      </div>

                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Update Bank Info</button>
                  </div>
                </form>

                @endif




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
            <div class="col-md-12">

              <div class="card card-primary">
                <div class="card-header mb-5">
                  <h3 class="card-title">Documents Info</h3>
                </div>

                <div class="row">
                  @foreach($userDocs as $row)

                  @php

                  $tempTitle = ucwords( str_replace('_',' ', $row->type));

                  @endphp

                  <div class="col-md-3">

                    <div class="card">
                      <img class="card-img-top height-img" src="{{url('')}}/users/employee-documents/images/{{$row->images}}" alt="">
                      <div class="card-body">
                        <h5 class="card-title">{{$tempTitle}}</h5>
                      </div>

                    </div>

                  </div>

                  @endforeach

                  @if(!empty($bankinfo))
                  <div class="col-md-3">

                    <div class="card">
                      <img class="card-img-top height-img" src="{{url('')}}/users/employee-documents/images/{{$bankinfo->passbook}}" alt="">
                      <div class="card-body">
                        <!-- <p class="card-text"></p> -->
                        <h5 class="card-title">Passbook of {{ $bankinfo->bank_name }} </h5>
                        <!-- <p class="card-text">{{ $bankinfo->acc_no }}</p>
                    <p class="card-text">{{ $bankinfo->ifsc }}</p>  -->
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">

                    <div class="card">

                      <div class="card-body">
                        <h4 class="pb-10">Bank Details</h4>
                        <div class="row">

                          <div class="col-md-4">
                            <h5>Bank Name</h5>
                            <div class="card-text">{{ $bankinfo->bank_name }} </div>
                          </div>
                          <div class="col-md-4">
                            <h5>Account Number</h5>
                            <div class="card-text">{{ $bankinfo->acc_no }}</div>
                          </div>
                          <div class="col-md-4">
                            <h5>IFSC Code</h5>
                            <div class="card-text">{{ $bankinfo->ifsc }}</div>
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <a href="{{url('')}}/admin/user/manage" class="btn btn-dark">Back to List</a>
                      </div>
                    </div>
                  </div>
                  @endif

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- /.content-wrapper -->

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  @include('admin.template.scripts')
  <script>
    let isAjax = false;
    let frmEle = "#edit-user-form";

    $(frmEle).on('submit', function(e) {
      e.preventDefault();
      let formEle = frmEle;
      if (!isAjax) {
        isAjax = true;
        $(this).children('div.card-footer').children('button[type=submit]').attr('disabled', 'true');
        let btnText = $('#frm-submit-btn').html();
        activeLoadingBtn("#frm-submit-btn");

        var Toast = Swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 3000
        });

        let user_info_url = $('#user_info_url').val();

        $.ajax({
          type: 'POST',
          url: user_info_url,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {

            if (res.code === 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
            } else if (res.code === 100) {
              showInvalidFields(res.err);
            } else {
              Toast.fire({
                icon: 'error',
                title: res.msg
              });
            }

            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          },
          error: function() {
            alert("did not work");
            isAjax = false;
            $(formEle).children('div.card-footer').children('button[type=submit]').removeAttr('disabled');
            resetLoadingBtn("#frm-submit-btn", btnText);
          }
        });
      }

    });
  </script>


  <script>
    $("#formBankInfo").on("submit", function(e) {
      e.preventDefault();


      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      var load = $('#loader');
      var btnTextload = $(load).html();

      $.ajax({
        url: `{{url('')}}/admin/manage/options/bank-info/add-new-bank-info`,
        type: 'post',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
          activeLoadingBtn(load);
          $('#loader').attr('disabled', 'disabled');

        },
        success: function(res) {

          resetLoadingBtn(load, btnTextload);

          $('#loader').removeAttr('disabled');

          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });

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

    $("#formBankInfoUpdate").on("submit", function(e) {
      e.preventDefault();


      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      var loadnew = $('#loader');
      var btnTextloadnew = $(loadnew).html();

      $.ajax({
        url: `{{url('')}}/admin/manage/options/bank-info/add-new-bank-info-update`,
        type: 'post',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
          activeLoadingBtn(loadnew);
          $('#loader').attr('disabled', 'disabled');

        },
        success: function(res) {

          resetLoadingBtn(loadnew, btnTextloadnew);

          $('#loader').removeAttr('disabled');

          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });
            $('#formSite').trigger('reset');
            // getDepList();
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
  </script>

</body>

</html>