<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ["title"=>"Access Denied"])
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
              <h1 class="m-0">Access Denied</h1>
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
                      <h3 class="card-title">Access Denied</h3>
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                  </div>
                </div>


                <div class="card-body">
                  <p>You are not authorised for this page.</p>
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


  @include('user_template.scripts')
</body>

</html>