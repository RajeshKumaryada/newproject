<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Edit User Personal Info"])
  <style>
    .height-img {
      height: 250px;
      max-height: 250px;
    }
    .vaccine-img{
      height: 250px;
      max-height: 250px;
      width:200px;
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


      <input type="hidden" id="hidden_token" value="{{csrf_token()}}">

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Salary of User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <form id="formSalary">
                  @csrf
                  <div class="card-body">

                    <div class="row">

                      <input type="hidden" name="user_id" value="{{ $userId }}">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Salary</label>
                          <input type="text" name="salary" id="salary" class="form-control" placeholder="Enter Salary">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Joining date</label>
                          <input type="date" name="created_at" id="created_at" class="form-control">
                        </div>
                      </div>

                    </div>

                  </div>


                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Add Salary</button>
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
      <input type="hidden" id="hidden_token" value="{{csrf_token()}}">

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Total Salary Found[<span id="tot-emps"></span>]</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Salary</th>
                        <th>Entry Date</th>
                        <th>Last Date</th>
                        <th>Status</th>
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


      <section class="content">
        <div class="content-fluid">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h1 class="m-0">User Address</h1>
                </div>

              </div>
            </div>
          </div>



          @if($userAddress->isEmpty())

          <form id="formUserAddress">
            @csrf

            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <!-- left column -->
                  <div class="col-md-12">
                    <!-- general form elements -->

                    <div class="card card-primary">

                      <div class="card-header">
                        <h3 class="card-title">Local Address</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->

                      <div class="card-body">
                        <div class="row">

                          <input type="hidden" name="user_id" value="{{ $userId }}">

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Address One</label>
                              <input type="text" name="local_address_line_one" id="local_address_line_one" class="form-control" value="" placeholder="Enter Address One">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Address Two</label>
                              <input type="text" name="local_address_line_two" id="local_address_line_two" class="form-control" value="" placeholder="Enter Address Two">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter City</label>
                              <input type="text" name="local_city" id="local_city" class="form-control" value="" placeholder="Enter Address Three">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>State</label>
                              <input type="text" name="local_state" id="local_state" class="form-control" value="" placeholder="Enter State">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Country</label>
                              <input type="text" name="local_country" id="local_country" class="form-control" value="" placeholder="Enter Country">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Postal Address</label>
                              <input type="text" name="local_postal_address" id="local_postal_address" class="form-control" value="" placeholder="Enter Postal Address">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="checkaddress" id="checkaddress" value="">Please Check if Permanent address same as Local Address
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
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
                        <h3 class="card-title">Permanent Address</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->

                      <div class="card-body">

                        <div class="row">

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Address One</label>
                              <input type="text" name="permanent_address_line_one" id="permanent_address_line_one" class="form-control" value="" placeholder="Enter Address One">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Address Two</label>
                              <input type="text" name="permanent_address_line_two" id="permanent_address_line_two" class="form-control" value="" placeholder="Enter Address Two">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter City</label>
                              <input type="text" name="permanent_city" id="permanent_city" class="form-control" value="" placeholder="Enter City">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>State</label>
                              <input type="text" name="permanent_state" id="permanent_state" class="form-control" value="" placeholder="Enter State">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Country</label>
                              <input type="text" name="permanent_country" id="permanent_country" class="form-control" value="" placeholder="Enter Country">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Postal Address</label>
                              <input type="text" name="permanent_postal_address" id="permanent_postal_address" class="form-control" value="" placeholder="Enter Postal Address">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- /.card-body -->

                      <div class="card-footer">
                        <button type="submit" id="loader" class="btn btn-primary float-right">Add User Address</button>
                      </div>
                    </div>
                    <!-- /.card -->
                  </div>
                  <!--/.col (left) -->
                </div>
                <!-- /.row -->
              </div><!-- /.container-fluid -->
            </section>


          </form>
          <!-- form End -->

          @else

          <!-- form start -->
          <form id="formUserAddressUpdate">
            @csrf

            @foreach($userAddress as $row)

            @if($row->address_type == 1)

            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <!-- left column -->
                  <div class="col-md-12">
                    <!-- general form elements -->

                    <div class="card card-primary">

                      <div class="card-header">
                        <h3 class="card-title">Local Address</h3>
                      </div>
                      <!-- /.card-header -->

                      <div class="card-body">
                        <div class="row">

                          <input type="hidden" name="local_id" value="{{ $row->id }}">
                          <input type="hidden" name="update_user_id" value="{{ $userId }}">

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Address One</label>
                              <input type="text" name="update_local_address_line_one" id="update_local_address_line_one" class="form-control" value="{{ $row->address_line_one}}">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Address Two</label>
                              <input type="text" name="update_local_address_line_two" id="update_local_address_line_two" class="form-control" value="{{ $row->address_line_two}}">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter City</label>
                              <input type="text" name="update_local_city" id="update_local_city" class="form-control" value="{{ $row->city}}">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>State</label>
                              <input type="text" name="update_local_state" id="update_local_state" class="form-control" value="{{ $row->state}}">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Country</label>
                              <input type="text" name="update_local_country" id="update_local_country" class="form-control" value="{{ $row->country}}" placeholder="Enter Country">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Postal Address</label>
                              <input type="text" name="update_local_postal_address" id="update_local_postal_address" class="form-control" value="{{ $row->postal_address}}" placeholder="Enter Postal Address">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!--/.col (left) -->

                </div>
                <!-- /.row -->
              </div><!-- /.container-fluid -->
            </section>

            @elseif($row->address_type == 2)

            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <!-- left column -->
                  <div class="col-md-12">
                    <!-- general form elements -->

                    <div class="card card-primary">

                      <div class="card-header">
                        <h3 class="card-title">Permanent Address</h3>
                      </div>
                      <!-- /.card-header -->

                      <div class="card-body">

                        <div class="row">

                          <input type="hidden" name="permanent_id" value="{{ $row->id }}">
                          <!-- <input type="hidden" name="user_id" value="{{ $userId }}"> -->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Address One</label>
                              <input type="text" name="update_permanent_address_line_one" id="update_permanent_address_line_one" class="form-control" value="{{ $row->address_line_one}}">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Address Two</label>
                              <input type="text" name="update_permanent_address_line_two" id="update_permanent_address_line_two" class="form-control" value="{{ $row->address_line_two}}">
                            </div>
                          </div>


                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter City</label>
                              <input type="text" name="update_permanent_city" id="update_permanent_city" class="form-control" value="{{ $row->city}}">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>State</label>
                              <input type="text" name="update_permanent_state" id="update_permanent_state" class="form-control" value="{{ $row->state}}">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Country</label>
                              <input type="text" name="update_permanent_country" id="update_permanent_country" class="form-control" value="{{ $row->country}}">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Enter Postal Address</label>
                              <input type="text" name="update_permanent_postal_address" id="update_permanent_postal_address" class="form-control" value="{{ $row->postal_address}}">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- /.card-body -->

                      <div class="card-footer">
                        <button type="submit" id="loader" class="btn btn-primary float-right">Update User Address</button>
                      </div>

                    </div>
                    <!-- /.card -->

                  </div>
                  <!--/.col (left) -->

                </div>
                <!-- /.row -->
              </div><!-- /.container-fluid -->
            </section>

            @endif

            @endforeach

          </form>
          <!-- /.End Form -->

          @endif



        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->

              <div class="card card-primary">

                <div class="card-header">
                  <h3 class="card-title">Vaccine Dose One</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <div class="card-body">
                  <div class="row">

                    <div class="col-md-4">
                    @foreach($userVaccineOne as $row)
                      @php
                      $ext = '';
                      if (!empty($row->file)) {
                      $ext = pathinfo($row->file, PATHINFO_EXTENSION);
                      }
                      @endphp

                      @if ($ext == 'pdf')
                      <a href="{{ url('') }}/users/employee-documents/images/{{ $row->file }}" download>View File
                      </a>
                      @else
                      <a href="{{ url('') }}/users/employee-documents/images/{{ $row->file }}" data-toggle="lightbox" data-title="" data-gallery="gallery">
                        <img class="card-img-top vaccine-img" src="{{ url('') }}/users/employee-documents/images/{{ $row->file }}" alt="">
                      </a>
                      @endif

                      @endforeach
                    </div>

                  </div>
                </div>
                <!-- /.card-body -->
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
                  <h3 class="card-title">Vaccine Dose Two</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <div class="card-body">
                  <div class="row">

                    <div class="col-md-4">

                      @foreach($userVaccineTwo as $row1)
                      @php
                      $ext = '';
                      if (!empty($row1->file)) {
                      $ext = pathinfo($row1->file, PATHINFO_EXTENSION);
                      }
                      @endphp

                      @if ($ext == 'pdf')
                      <a href="{{ url('') }}/users/employee-documents/images/{{ $row1->file }}" download>View File
                      </a>
                      @else
                      <a href="{{ url('') }}/users/employee-documents/images/{{ $row1->file }}" data-toggle="lightbox" data-title="" data-gallery="gallery">
                        <img class="card-img-top vaccine-img" src="{{ url('') }}/users/employee-documents/images/{{ $row1->file }}" alt="">
                      </a>
                      @endif

                      @endforeach
                    </div>

                  </div>
                </div>
                <!-- /.card-body -->
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
  <div class="modal fade" id="myModaledit">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Salary</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">

              <form id="formSalaryUpdate">
                @csrf

                <input type="hidden" name="update_user_id" value="{{ $userId }}">
                <input type="hidden" name="update_id" id="update_id">

                <div class="form-group">
                  <label>Enter Salary</label>
                  <input type="text" name="update_salary" id="update_salary" class="form-control">
                </div>

                <div class="form-group">
                  <label>Enter Joining date</label>
                  <input type="date" name="update_created_at" id="update_created_at" class="form-control">
                </div>

                <div class="form-group">
                  <label>Last date</label>
                  <input type="date" name="update_last_date" id="update_last_date" class="form-control">
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="update_status" id="update_status">
                    <option value="1">Active</option>
                    <option value="0">Not Active</option>
                  </select>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" id="loader" class="btn btn-primary float-right">Update Salary</button>
                </div>

              </form>
            </div>
          </div>
        </div>



      </div>
    </div>
  </div>
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

  <script>
    var dataTableObj;

    $(function() {
      $("#data-table").DataTable({
        columnDefs: [{
          bSortable: false,
          targets: [1]
        }],
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

      dataTableObj = $("#data-table").DataTable();
      getDepList();
    });

    function getDepList() {
      dataTableObj.clear().draw();
      let url = `{{url('')}}/ajax/admin/manage/salary/list/{{$userId}}`;
      getAjaxData(dataTableObj, url, setTableData);
    }

    function setTableData(tbl_id, response) {

      let count = 0;
      //for loop
      response.data.forEach((ele, idx) => {

        // let editButton = `<button class="btn btn-sm btn-danger edit-dep" value="${ele.dep_id}" data-depname="${ele.dep_name}">
        //             Edit
        //           </button>`;

        let menu = `<div>
                      <button class="btn btn-sm btn-link text-primary edit-salary" value="${ele.id}" data-salary="${ele.salary}" data-createdat="${ele.created_at}" data-lastdate="${ele.last_date}" data-status="${ele.status}">
                           <i class="fas fa-edit"></i>
                          </button>
                          
                          <button class="btn btn-sm btn-link text-danger delete-salary" value="${ele.id}">
                        <i class="fas fa-trash"></i>
                      </button>
                      </div>`;


        tbl_id.row.add(
          [
            (++count),
            menu,
            ele.salary,
            ele.created_at,
            ele.last_date,
            ele.status
          ]
        ).draw(false);
      });

      //end for loop

      document.getElementById('tot-emps').innerHTML = count;
    }

    let Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });

    $("#formSalary").on("submit", function(e) {
      e.preventDefault();


      var load = $('#loader');
      var btnTextload = $(load).html();

      $.ajax({
        url: `{{url('')}}/ajax/admin/manage/salary/add-new`,
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
            $('#formSite').trigger('reset');
            getDepList();
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

    /**
     * Edit Salary
     */
    $('#data-table').on('click', '.edit-salary', function() {
      var id = $(this).val();
      var salary = $(this).attr("data-salary");
      var createdAt = $(this).attr("data-createdat");
      var lastDate = $(this).attr("data-lastdate");
      var siteStatus = $(this).attr("data-status");
      var token = $('#hidden_token').val();

      $('#update_id').val(id);
      $('#update_salary').val(salary);
      $('#update_created_at').val(createdAt);
      $('#update_last_date').val(lastDate);
      $('#update_status').val(siteStatus);
      $("#myModaledit").modal("show");
    });


    /** 
     * Update Salary
     */
    $("#formSalaryUpdate").on("submit", function(e) {
      e.preventDefault();

      var loadnew = $('#loader');
      var btnTextloadnew = $(loadnew).html();

      $.ajax({
        url: `{{url('')}}/ajax/admin/manage/salary/update`,
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
            $('#formSalaryUpdate').trigger('reset');
            $('#myModaledit').modal('hide');
            getDepList();
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
    /**
     * Delete Salary
     */
    $('#data-table').on('click', '.delete-salary', function() {

      if (!confirm('Are you sure you want to Delete')) {
        return;
      }

      var id = $(this).val();
      var token = $('#hidden_token').val();

      $.ajax({
        url: "{{url('')}}/ajax/admin/manage/salary/delete",
        type: 'post',
        data: {
          id: id,
          _token: token
        },
        // contentType: false,
        // processData: false,
        success: function(res) {
          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });
            getDepList(dataTableObj);
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

  <script>
    $('#checkaddress').on('change', function() {

      if ($('#checkaddress').prop('checked')) {
        var locOneAdd = $('#local_address_line_one').val();
        var locTwoAdd = $('#local_address_line_two').val();
        var locCity = $('#local_city').val();
        var locState = $('#local_state').val();
        var locCountry = $('#local_country').val();
        var locPostal = $('#local_postal_address').val();

        $('#permanent_address_line_one').val(locOneAdd);
        $('#permanent_address_line_two').val(locTwoAdd);
        $('#permanent_city').val(locCity);
        $('#permanent_state').val(locState);
        $('#permanent_country').val(locCountry);
        $('#permanent_postal_address').val(locPostal);
      }
    });

    $("#formUserAddress").on("submit", function(e) {
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
        url: `{{url('')}}/admin/manage/address/user/add-new-address`,
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
            $('#formUserAddress').trigger('reset');
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

    $("#formUserAddressUpdate").on("submit", function(e) {
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
        url: `{{url('')}}/admin/manage/address/user/update`,
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
            // $('#formSite').trigger('reset');
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

    //    var check = $('#checkbox').is(':checked'); 
  </script>


</body>

</html>