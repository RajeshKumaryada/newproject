<!DOCTYPE html>
<html lang="en">

<head>

  @include('user_template.head', ['title'=>'Admin Access Page List'])
  <style>
    .dishfw tbody tr td:nth-child(9),
    .tdhf {
      display: none;
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
              <h1 class="m-0">Admin Access Page List</h1>
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

                    <div class="col-md-12">
                      <h3 class="card-title">Allowed Admin Pages</h3>
                    </div>
                  </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  @if($pageList->isEmpty())

                  <h6>You hane no Admin Access Pages.</h6>

                  @else

                  <table id="data-tbl" class="table table-sm table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 30px;">#</th>
                        <th>Page Name</th>
                        <th>Page URL</th>
                        <th>Open</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $count = 0; @endphp
                      @foreach($pageList as $row)

                      <tr>
                        <td>{{++$count}}</td>
                        <td>{{$row->pageUrl->page_name}}</td>
                        <td>{{$row->pageUrl->page_url}}</td>
                        <td><a href="{{url('login-to-admin-access')}}/{{encrypt($row->id)}}" target="_blank">Open</a></td>
                      </tr>

                      @endforeach
                    </tbody>
                  </table>

                  @endif

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

    @include('user_template.footer')


  </div>
  <!-- ./wrapper -->

  @include('user_template.scripts')

  <script>
    $(function() {
      $("#data-tbl").DataTable({
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
      }).buttons().container().appendTo('#data-tbl_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>

</html>