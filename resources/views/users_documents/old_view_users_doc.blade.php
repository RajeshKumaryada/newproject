<!DOCTYPE html>
<html lang="en">

<head>
  @include('user_template.head', ['title'=>'Users Document'])

  <style>
    .clear-btn {
      cursor: pointer;
    }

    .height-img {
      max-height: 250px;
      height: 250px;
    }
    .vaccine-img{
      max-height: 250px;
      height: 250px;
      width:150px;
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
              <h1 class="m-0">View Documents</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->


      <section class="content">
        <div class="container-fluid">
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
                <ul class="list-group list-group-flush">

                  @if($row->usersDocumentTemp()->where('status',0)->count() > 0)
                  <li class="list-group-item">
                    <p>Under Review</p>
                  </li>
                  @elseif(!empty($row->usersDocumentTemp->remark))
                  <li class="list-group-item">
                    <button class="btn btn-danger btn-small get-id-single" id="btn_{{$row->type}}" data-id="{{$row->id}}" data-title="Update {{$tempTitle}}" data-type="{{$row->type}}">Update</button>
                    <p class="pt-2">Note: {{$row->usersDocumentTemp->remark}}</p>
                  </li>
                  @else
                  <li class="list-group-item">
                    <button class="btn btn-danger btn-small get-id-single" id="btn_{{$row->type}}" data-id="{{$row->id}}" data-title="Update {{$tempTitle}}" data-type="{{$row->type}}">Update</button>
                  </li>
                  @endif
                </ul>
                <div class="card-body">
                </div>
              </div>

            </div>

            @endforeach

            @if(!empty($bankinfo))

            <div class="col-md-12">

              <div class="card">

                <div class="card-body">
                  <h4 class="pb-10">Bank Details</h4>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="card">
                        <img class="card-img-top height-img" src="{{url('')}}/users/employee-documents/images/{{$bankinfo->passbook}}" alt="">
                        <div class="card-body">
                          <p class="card-text">Passbook of {{ $bankinfo->bank_name }} </p>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <h5>Bank Name</h5>
                      <div class="card-text">{{ $bankinfo->bank_name }} </div>
                    </div>
                    <div class="col-md-3">
                      <h5>Account Number</h5>
                      <div class="card-text">{{ $bankinfo->acc_no }}</div>
                    </div>
                    <div class="col-md-3">
                      <h5>IFSC Code</h5>
                      <div class="card-text">{{ $bankinfo->ifsc }}</div>
                    </div>

                  </div>


                  <ul class="list-group list-group-flush">
                    @if($bankinfo->usersBankInfoTemp()->where('status',0)->count() > 0)

                    <li class="list-group-item pl-0">
                      <p class="text-dark">Under Review</p>
                    </li>
                    @elseif(!empty($bankinfo->usersBankInfoTemp->remark))
                    <li class="list-group-item pl-0">
                      <button class="btn btn-danger btn-small bank-info-btn" id="bank-info-btn" data-id="{{$bankinfo->id}}" data-bankname="{{$bankinfo->bank_name}}" data-accno="{{$bankinfo->acc_no}}" data-ifsc="{{$bankinfo->ifsc}}" data-passbook="{{$bankinfo->passbook}}">Update</button>
                      <p class="pt-2">Note: {{$bankinfo->usersBankInfoTemp->remark}}</p>
                    </li>

                    @else
                    <li class="list-group-item pl-0">
                      <button class="btn btn-danger btn-small bank-info-btn" id="bank-info-btn" data-id="{{$bankinfo->id}}" data-bankname="{{$bankinfo->bank_name}}" data-accno="{{$bankinfo->acc_no}}" data-ifsc="{{$bankinfo->ifsc}}" data-passbook="{{$bankinfo->passbook}}">Update</button>
                    </li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
            @endif
          </div>

        </div>
      </section>


      <!-- Local Address Functionality -->
      @if($countAddressLocalTemp > 0)
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <div class="card card-primary">

                <div class="card-header">
                  <h3 class="card-title">Update Address</h3>
                </div>

                <div class="card-body">
                  <h3 class="card-title">Local Address in under review </h3>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      @elseif($countAddressLocalTempDeny > 0)
      @foreach($userAddressTempStatusLocal as $row_status_local)
      <form id="formAddresslocalUpdate">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">

                <!-- general form elements -->

                <div class="card card-primary">

                  <div class="card-header">
                    <h3 class="card-title">Update Local Address</h3>
                  </div>
                  <!-- /.card-header -->

                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">

                        @if($row_status_local->count() > 0)

                        <p>Request Denied : {{ $row_status_local->remark }}</p>

                        @endif


                      </div>
                      <input type="hidden" name="local_id" value="{{ $row_status_local->id }}">
                      <input type="hidden" name="update_user_id" value="{{ $row_status_local->user_id }}">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Address One</label>
                          <input type="text" name="update_local_address_line_one" id="update_local_address_line_one" class="form-control" value="{{ $row_status_local->address_line_one}}">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Address Two</label>
                          <input type="text" name="update_local_address_line_two" id="update_local_address_line_two" class="form-control" value="{{ $row_status_local->address_line_two}}">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter City</label>
                          <input type="text" name="update_local_city" id="update_local_city" class="form-control" value="{{ $row_status_local->city}}">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>State</label>
                          <input type="text" name="update_local_state" id="update_local_state" class="form-control" value="{{ $row_status_local->state}}">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Country</label>
                          <input type="text" name="update_local_country" id="update_local_country" class="form-control" value="{{ $row_status_local->country}}" placeholder="Enter Country">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Postal Address</label>
                          <input type="text" name="update_local_postal_address" id="update_local_postal_address" class="form-control" value="{{ $row_status_local->postal_address}}" placeholder="Enter Postal Address">
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
      </form>
      @endforeach
      @else

      @foreach($userAddress as $row)
      <!-- when useraddress document update -->
      @if($row->address_type == 1)

      <form id="formAddressUpdatelocal">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                      <input type="hidden" name="update_user_id" value="{{ $row->user_id }}">

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
      </form>

      @endif
      @endforeach

      @endif

      <!-- Permannet Address Functionality -->
      @if($countAddressPerTemp > 0)
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <div class="card card-primary">

                <div class="card-header">
                  <h3 class="card-title">Update Address</h3>
                </div>

                <div class="card-body">
                  <h3 class="card-title">Permanent Address in under review </h3>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      @elseif($countAddressPermTempDeny > 0)
      @foreach($userAddressTempStatusPerm as $row_status_Per)
      <form id="formAddresspermanentUpdate">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <section class="content">
          <div class="container-fluid">
            <div class="row">

              <div class="col-md-12">



                <div class="card card-primary">

                  <div class="card-header">
                    <h3 class="card-title">Update Permanent Address</h3>
                  </div>


                  <div class="card-body">

                    <div class="row">
                      <div class="col-md-12">

                        @if($row_status_Per->count() > 0)
                        <p>Request Denied : {{ $row_status_Per->remark }}</p>
                        @endif


                      </div>
                      <input type="hidden" name="permanent_id" value="{{ $row_status_Per->id }}">
                      <input type="hidden" name="update_user_id" value="{{ $row_status_Per->user_id }}">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Address One</label>
                          <input type="text" name="update_permanent_address_line_one" id="update_permanent_address_line_one" class="form-control" value="{{ $row_status_Per->address_line_one}}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Address Two</label>
                          <input type="text" name="update_permanent_address_line_two" id="update_permanent_address_line_two" class="form-control" value="{{ $row_status_Per->address_line_two}}">
                        </div>
                      </div>


                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter City</label>
                          <input type="text" name="update_permanent_city" id="update_permanent_city" class="form-control" value="{{ $row_status_Per->city}}">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>State</label>
                          <input type="text" name="update_permanent_state" id="update_permanent_state" class="form-control" value="{{ $row_status_Per->state}}">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Country</label>
                          <input type="text" name="update_permanent_country" id="update_permanent_country" class="form-control" value="{{ $row_status_Per->country}}">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Enter Postal Address</label>
                          <input type="text" name="update_permanent_postal_address" id="update_permanent_postal_address" class="form-control" value="{{ $row_status_Per->postal_address}}">
                        </div>
                      </div>
                    </div>
                  </div>



                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Update User Address</button>
                  </div>

                </div>


              </div>


            </div>

          </div>
        </section>

      </form>

      @endforeach
      @else
      @foreach($userAddress as $row)
      @if($row->address_type == 2)

      <form id="formAddressUpdatepermanent">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                      <input type="hidden" name="update_user_id" value="{{ $row->user_id }}">

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

      </form>
      @endif
      @endforeach

      @endif

      @if($vacDataOne > 0)
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <div class="card card-primary">

                <div class="card-header">
                <h3 class="card-title">Your First Dose Certificate Saved.</h3>
                </div>

                <div class="card-body">
                  
                  @foreach($vacDataOneData as $row)
                  @php
                                        $ext = '';
                                        if (!empty($row->file)) {
                                          $ext  = pathinfo($row->file, PATHINFO_EXTENSION);
                                        }
                                           @endphp

                                           @if ($ext == 'pdf')
                                                  <a href="{{ url('') }}/users/employee-documents/images/{{ $row->file }}"
                                                   download>View File
                                                  </a>
                                                  @else
                                                  <a href="{{ url('') }}/users/employee-documents/images/{{ $row->file }}"
                                                    data-toggle="lightbox"
                                                    data-title=""
                                                    data-gallery="gallery">
                                                    <img class="card-img-top vaccine-img"
                                                        src="{{ url('') }}/users/employee-documents/images/{{ $row->file }}"
                                                        alt="">
                                                </a>
                                                  @endif

                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      @else


      <form id="formDoseOne">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">

                <!-- general form elements -->

                <div class="card card-primary">

                  <div class="card-header">
                    <h3 class="card-title">Vaccine Certificates Upload Dose One</h3>
                  </div>
                  <!-- /.card-header -->

                  <div class="card-body">
                    <div class="row">
                      <input type="hidden" name="type" value="1">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Vaccine Certificate Dose One</label>
                          <input type="file" name="vac_certificate_one" id="vac_certificate_two" class="form-control" value="">
                        </div>
                      </div>

                    </div>
                  </div>

                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Add Vaccine One</button>
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
      @endif




      @if($vacDataTwo > 0)
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <div class="card card-primary">

                <div class="card-header">
                <h3 class="card-title">Your Second Dose Certificate Saved.</h3>
                </div>

                <div class="card-body">
                  
                  @foreach($vacDataTwoData as $row)
                  @php
                                        $ext = '';
                                        if (!empty($row->file)) {
                                          $ext  = pathinfo($row->file, PATHINFO_EXTENSION);
                                        }
                                           @endphp

                                           @if ($ext == 'pdf')
                                                  <a href="{{ url('') }}/users/employee-documents/images/{{ $row->file }}"
                                                   download>View File
                                                  </a>
                                                  @else
                                                  <a href="{{ url('') }}/users/employee-documents/images/{{ $row->file }}"
                                                    data-toggle="lightbox"
                                                    data-title=""
                                                    data-gallery="gallery">
                                                    <img class="card-img-top vaccine-img"
                                                        src="{{ url('') }}/users/employee-documents/images/{{ $row->file }}"
                                                        alt="">
                                                </a>
                                                  @endif

                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      @else

      <form id="formDoseTwo">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">

                <!-- general form elements -->

                <div class="card card-primary">
                  <input type="hidden" name="type" value="2">
                  <div class="card-header">
                    <h3 class="card-title">Vaccine Certificates Upload Dose Two</h3>
                  </div>
                  <!-- /.card-header -->

                  <div class="card-body">
                    <div class="row">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Vaccine Certificate Dose Two</label>
                          <input type="file" name="vac_certificate_two" id="vac_certificate_two" class="form-control" value="">
                        </div>
                      </div>



                    </div>
                  </div>

                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" id="loader" class="btn btn-primary float-right">Add Vaccine Two</button>
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
      @endif






      <!-- @include('user_template.footer') -->
    </div>
  </div>


  <!-- The Modal -->
  <div class="modal fade" id="get-doc-modal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"></h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="temp-doc-image">
          <!-- Modal body -->
          <div class="modal-body">

            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="type" id="type">
            <div class="form-group">
              <label for="pwd">Uploading Image:</label>
              <input type="file" class="form-control" name="images" id="images">
            </div>

          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- The Modal -->
  <div class="modal fade" id="get-bank-info-modal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="bank-info-form">
          <!-- Modal body -->
          <div class="modal-body">

            @csrf
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="pwd">Passbook:</label>
              <input type="file" class="form-control" name="passbook" id="passbook">
            </div>

            <div class="form-group">
              <label for="pwd">Bank Name:</label>
              <input type="text" class="form-control" name="bank_name" id="bank_name">
            </div>

            <div class="form-group">
              <label for="pwd">Account No.:</label>
              <input type="text" class="form-control" name="acc_no" id="acc_no">
            </div>

            <div class="form-group">
              <label for="pwd">IFSC Code:</label>
              <input type="text" class="form-control" name="ifsc" id="ifsc">
            </div>

          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
          </div>
        </form>
      </div>
    </div>
  </div>


  @include('user_template.scripts')

  <script>
    $(function() {

      $('.get-id-single').on('click', function() {

        var id = $(this).attr('data-id');
        var title = $(this).attr('data-title');
        var type = $(this).attr('data-type');
        // console.log(title, this);

        $('#get-doc-modal .modal-title').html(title);
        $('#get-doc-modal input#id').val(id);
        $('#get-doc-modal input#type').val(type);
        $('#get-doc-modal').modal('show');
      });


      $('.bank-info-btn').on('click', function() {

        var id = $(this).attr('data-id');
        // var passbook = $(this).attr('data-passbook');
        var bankname = $(this).attr('data-bankname');
        var acc_no = $(this).attr('data-accno');
        var ifsc = $(this).attr('data-ifsc');

        // console.log(title, this);
        $('#bank-info-form input#id').val(id);
        $('#bank-info-form input#bank_name').val(bankname);
        $('#bank-info-form input#acc_no').val(acc_no);
        $('#bank-info-form input#ifsc').val(ifsc);
        $('#get-bank-info-modal').modal('show');
      });

      let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });

      $("#temp-doc-image").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
          url: "{{url('')}}/users/employee-documents/temp-insert",
          type: 'post',
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              $("#get-doc-modal").modal("hide");

              $('#btn_' + res.type).attr('disabled', 'true');


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

      $("#bank-info-form").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
          url: "{{url('')}}/users/employee-documents/bank-info-temp-insert",
          type: 'post',
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function(res) {
            if (res.code == 200) {
              Toast.fire({
                icon: 'success',
                title: res.msg
              });
              $("#get-bank-info-modal").modal("hide");
              $('#bank-info-btn').attr('disabled', 'true');

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

    });



    $("#formAddressUpdatelocal").on("submit", function(e) {
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
        url: `{{url('')}}/users/employee-documents/update-address-local`,
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
            window.reload();

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


    $("#formAddressUpdatepermanent").on("submit", function(e) {
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
        url: `{{url('')}}/users/employee-documents/update-address-permanent`,
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
            window.reload();

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

    $("#formAddresslocalUpdate").on("submit", function(e) {
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
        url: `{{url('')}}/users/employee-documents/local-update`,
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
            window.reload();

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

    $("#formAddresspermanentUpdate").on("submit", function(e) {
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
        url: `{{url('')}}/users/employee-documents/permanent-update`,
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
            window.reload();

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

    $("#formUserUpdateDeny").on("submit", function(e) {
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
        url: `{{url('')}}/users/employee-documents/update-address-deny`,
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


    $("#formDoseOne").on("submit", function(e) {
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
        url: `{{url('')}}/users/employee-documents/add-vaccine-one`,
        type: 'post',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
          activeLoadingBtn(loadnew);
          $('#loader').attr('disabled', 'disabled');

        },
        success: function(res) {

          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });


            resetLoadingBtn(loadnew, btnTextloadnew);

            $('#loader').removeAttr('disabled');
            $('#formDoseOne')[0].reset();
            window.reload();
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

    $("#formDoseTwo").on("submit", function(e) {
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
        url: `{{url('')}}/users/employee-documents/add-vaccine-two`,
        type: 'post',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
          activeLoadingBtn(loadnew);
          $('#loader').attr('disabled', 'disabled');

        },
        success: function(res) {

          if (res.code == 200) {
            Toast.fire({
              icon: 'success',
              title: res.msg
            });


            resetLoadingBtn(loadnew, btnTextloadnew);

            $('#loader').removeAttr('disabled');
            $('#formDoseTwo')[0].reset();
            window.reload();
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