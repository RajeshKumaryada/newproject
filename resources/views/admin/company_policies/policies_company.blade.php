<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ["title"=>"Company policies"])
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
                            <h1 class="m-0">Company policies</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-primary">
                                            <h4 class="card-title">Policies</h4>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Files</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <!-- href="{{ asset('manage/user-policies/users_policy/sample.pdf') }}" -->
                                                <td><a class="get_url" href="#" data-heading ="Appraisal Policy" data-url="{{ asset('admin/company-policies/users_policy/appraisal-policy.pdf') }}" >Appraisal Policy</a></td>        
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><a class="get_url" href="#" data-heading ="Code of Conduct" data-url="{{ asset('admin/company-policies/users_policy/code-of-conduct.pdf') }}" >Code of Conduct</a></td>
                                            </tr>
                                          

                                            <tr>
                                                <td>3</td>
                                                <td><a class="get_url" href="#" data-heading ="Data Collection & Monitoring Policy" data-url="{{ asset('admin/company-policies/users_policy/data-collection-and-monitoring-policy.pdf') }}">Data Collection & Monitoring Policy</a></td>
                                            </tr>

                                            <tr>
                                                <td>4</td>
                                                <td><a class="get_url" href="#" data-heading ="Dress Code Policy" data-url="{{ asset('admin/company-policies/users_policy/dress-code-policy.pdf') }}">Dress Code Policy</a></td>
                                            </tr>

                                            <tr>
                                                <td>5</td>
                                                <td><a class="get_url" href="#" data-heading ="Harassment Policy" data-url="{{ asset('admin/company-policies/users_policy/harassment-policy.pdf') }}">Harassment Policy</a></td>
                                            </tr>

                                            <tr>
                                                <td>6</td>
                                                <td><a class="get_url" href="#" data-heading ="Leave Policy" data-url="{{ asset('admin/company-policies/users_policy/leave-policy.pdf') }}">Leave Policy</a></td>
                                            </tr>

                                            <tr>
                                                <td>7</td>
                                                <td><a class="get_url" href="#" data-heading ="Pay Policy" data-url="{{ asset('admin/company-policies/users_policy/pay-policy.pdf') }}">Pay Policy</a></td>
                                            </tr>

                                            <tr>
                                                <td>8</td>
                                                <td><a class="get_url" href="#" data-heading ="Resignation or Termination Policy" data-url="{{ asset('admin/company-policies/users_policy/resignation-or-termination-policy.pdf') }}">Resignation or Termination Policy</a></td>
                                            </tr>

                                            <tr>
                                                <td>9</td>
                                                <td><a class="get_url" href="#" data-heading ="Use of Company Property Policy" data-url="{{ asset('admin/company-policies/users_policy/use-of-company-property-policy.pdf') }}">Use of Company Property Policy</a></td>
                                            </tr>

                                            <tr>
                                                <td>10</td>
                                                <td><a class="get_url" href="#" data-heading ="Work From Home Policy" data-url="{{ asset('admin/company-policies/users_policy/work-from-home-policy.pdf') }}">Work From Home Policy</a></td>
                                            </tr>

                                            <tr>
                                                <td>11</td>
                                                <td><a class="get_url" href="#" data-heading ="Working Hours (Attendance) Policy" data-url="{{ asset('admin/company-policies/users_policy/working-hours-policy.pdf') }}">Working Hours (Attendance) Policy</a></td>
                                            </tr>

                                           
                                            </tbody>
                                        </table>
                                           
                                        </div>
                                        <!-- /.card-body -->

                                      
                                    </div>
                                </div>

                              
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>



        </div>


    </div>

    <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
         
         
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         
        </div>
        
      </div>
    </div>
  </div>

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  @include('admin.template.scripts')
  <script>
         $('.get_url').on('click', function() {
              
            $id = $(this).val();
            var head = $(this).attr('data-heading');
            var url = $(this).attr('data-url');
            // alert(url);
            //  alert(des);
            
            $('.modal-header').html(`<h4 class="modal-title">${head}</h4><h6 class="mt-2 ml-2"><a href="${url}" download>Download</a></h6> <button type="button" class="close" data-dismiss="modal">&times;</button>`);
            $('.modal-body').html(`<embed src='${url}' width='100%' height='800px'>`);
            $('.modal-body').html(`<embed src='${url}' width='100%' height='800px'>`);
            $('#modal-detail').modal('show');

        }); 
    </script>

</body>

</html>