<!DOCTYPE html>
<html lang="en">

<head>

  @php
  if($userInfo->isEmpty())
  $title = 'Add User Address';
  else
  $title = 'Update User Address';
  @endphp

  @include('admin.template.head', ["title"=>$title])
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
              <h1 class="m-0">{{ $title }}</h1>
            </div>

          </div>
        </div>
      </div>

      @if($userInfo->isEmpty())

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

        @foreach($userInfo as $row)

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
    <!-- /.content-wrapper -->

    @include('admin.template.footer')


  </div>
  <!-- ./wrapper -->

  @include('admin.template.scripts')
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
        url: `{{url('')}}/admin/manage/address/user/addNewAddress`,
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