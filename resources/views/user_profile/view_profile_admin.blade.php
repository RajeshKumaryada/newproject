<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ['title'=>'Admin Profile'])
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
              <h1 class="m-0">Profile</h1>
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
                  <h3 class="card-title">View Profile</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="work-start-form">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Username</label>
                          <div class="form-control">{{$user->username}}</div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email Address</label>
                          <div class="form-control">{{$user->email}}</div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Department</label>
                          <div class="form-control">{{$user->department()->first()->dep_name}}</div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Post</label>
                          <div class="form-control">{{$user->post()->first()->post_name}}</div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Designation</label>
                          <div class="form-control">{{$user->designation()->first()->des_name}}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    
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
    <!-- /.content-wrapper -->

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  @include('admin.template.scripts')
</body>

</html>