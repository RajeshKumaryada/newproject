<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ['title'=>'Profile'])
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
              <h1 class="m-0">Profile</h1>
            </div>
          </div>
        </div>
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
                  <h3 class="card-title">Login and Department</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Username</label>
                          <div class="form-control">{{$user->username}}</div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Email Address</label>
                          <div class="form-control">{{$user->email}}</div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Department</label>
                          <div class="form-control">{{$user->department()->first()->dep_name}}</div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Post</label>
                          <div class="form-control">{{$user->post()->first()->post_name}}</div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Designation</label>
                          <div class="form-control">{{$user->designation()->first()->des_name}}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer"></div>
                </form>
              </div>
              <!-- /.card -->

            </div>
            <!--/.col (left) -->

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>


      @if(!empty($user->usersInfo))

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Personal Info</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>

                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>EMP Code</label>
                          <div class="form-control">{{$user->usersInfo->emp_code}}</div>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>First Name</label>
                          <div class="form-control">{{$user->usersInfo->first_name}}</div>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Middle Name</label>
                          <div class="form-control">{{$user->usersInfo->middle_name}}</div>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Last Name</label>
                          <div class="form-control">{{$user->usersInfo->last_name}}</div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Email</label>
                          <div class="form-control">{{$user->usersInfo->personal_email}}</div>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Work Phone</label>
                          <div class="form-control">{{$user->usersInfo->work_phone}}</div>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Personal Phone</label>
                          <div class="form-control">{{$user->usersInfo->personal_phone}}</div>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Gender</label>

                          @if($user->usersInfo->gender === 'm')
                          <div class="form-control">Male</div>
                          @elseif($user->usersInfo->gender === 'f')
                          <div class="form-control">Female</div>
                          @elseif($user->usersInfo->gender === 'o')
                          <div class="form-control">Other</div>
                          @endif

                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Date of Joining</label>
                          <div class="form-control">{{$user->usersInfo->date_of_joining}}</div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer"></div>
                </form>
              </div>
              <!-- /.card -->

            </div>
            <!--/.col (left) -->

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>

      @endif

    </div>
    <!-- /.content-wrapper -->

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->

  @include('user_template.scripts')
</body>

</html>