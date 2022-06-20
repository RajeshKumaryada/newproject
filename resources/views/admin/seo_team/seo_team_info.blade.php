<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.template.head', ['title'=>'SEO Team Info'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    @include('admin.template.nav')


    @include('admin.template.aside')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <h1 class="m-0">Teams Info</h1>
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
                      <h2 class="h2">HR Contact</h2>
                    </div>
                    <div class="col-md-4 text-right">
                      <h1>
                        <a target="_blank" href="https://www.linkedin.com/company/logelite-pvt-ltd/"><i class="fab fa-linkedin"></i></a>
                        <a target="_blank" href="https://www.facebook.com/Logelite-Pvt-Ltd-104925764830056/"><i class="fab fa-facebook-square"></i></a>
                        <a target="_blank" href="https://twitter.com/limitedlogelite"><i class="fab fa-twitter-square"></i></a>
                      </h1>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <div class="row mb-3">
                    <div class="col-md-3">
                      <div class="form-control">Ali</div>
                    </div>
                    <div class="col-md-9">
                      <a href="tel:+918874788206" class="form-control">+91-8874788206</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-control">Pavitra</div>
                    </div>
                    <div class="col-md-9">
                      <a href="tel:+918957399157" class="form-control">+91-8957399157</a>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer text-right"></div>
              </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>

      @php
      $teamType = 0;
      @endphp

      @foreach($teamInfo as $row)

      @if($teamType != $row->team_type)
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <h2 class="m-0">TEAM: {{$workTeamType->value($row->team_type)}}</h2>
            </div>
          </div>
        </div>
      </div>

      @php
      $teamType = $row->team_type;
      @endphp

      @endif

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card mb-4 card-primary">
                <div class="card-header">
                  <h2 class="card-title">{{$row->team_name}}</h2>
                </div>

                <div class="card-body text-dark" style="padding: 1px;">

                  @php
                  $count = 0;
                  @endphp
                   <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Emp Name</th>
                          <th>Designation</th>
                          <th>Contact</th>
                          <th>Member Type</th>
                          <th>Working Sites</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($row->workTeamMembers as $row2)

                        @php

                        if(!empty($row2->users->usersInfo->work_phone)):

                        $phone = $row2->users->usersInfo->work_phone;
                        $phone = "<a class='h5' href='tel:{$phone}'>{$phone}</a>";

                        else:

                        $phone = '';

                        endif

                        @endphp

                        <tr>

                          @if($row2->member_type == 'team_leader')

                          <td>{{++$count}}</td>
                          <td>{{$row2->username->username}}</td>
                          <td>{{$row2->users->designation()->first()->des_name}}</td>
                          <td>{!!$phone!!}</td>
                          <td><span class="badge badge-danger user-badge" title="Team Leader">Team Leader</span></td>
                          <td>

                            @if($workTeamType->value($row->team_type) == "SEO Sales")

                            @if(!empty($row2->users->siteUsersRelation))
                            @foreach($row2->users->siteUsersRelation as $row3)

                            <a href="{{$row3->siteInfo->site_url}}" target="_blank" title="{{$row3->siteInfo->site_url}}">
                              <span class="badge badge-primary user-badge cur-ptr">{{$row3->siteInfo->site_name}}</span>
                            </a>

                            @endforeach
                            @endif

                            @endif

                          </td>

                          @elseif($row2->member_type == 'team_member')

                          <td>{{++$count}}</td>
                          <td>{{$row2->username->username}}</td>
                          <td>{{$row2->users->designation()->first()->des_name}}</td>
                          <td>{!!$phone!!}</td>
                          <td><span class="badge badge-success user-badge" title="Team Member">Team Member</span></td>
                          <td>

                            @if($workTeamType->value($row->team_type) == "SEO Sales")

                            @if(!empty($row2->users->siteUsersRelation))
                            @foreach($row2->users->siteUsersRelation as $row3)

                            <a href="{{$row3->siteInfo->site_url}}" target="_blank" title="{{$row3->siteInfo->site_url}}">
                              <span class="badge badge-primary user-badge cur-ptr">{{$row3->siteInfo->site_name}}</span>
                            </a>

                            @endforeach
                            @endif

                            @endif

                          </td>

                          @endif

                        </tr>

                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer"></div>
              </div>

            </div>
          </div>
        </div>
      </section>

      @endforeach


      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h2 class="h2">Content Writer Teams</h2>
            </div>
          </div>
        </div>
      </div>


      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card mb-4 card-primary">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <h2 class="card-title">Team Content Writers</h2>
                    </div>
                    <div class="col-md-4">
                      <h2 class="card-title float-right"><a href="tel:+918874788206">+91-8874788206</a></h2>
                    </div>
                  </div>
                </div>

                <div class="card-body text-dark" style="padding: 1px;">

                  @php
                  $count = 0;
                  @endphp
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Emp Name</th>
                          <th>Designation</th>
                          <th>Contact</th>
                          <th>Member Type</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($contentWriters as $row)

                        @php

                        if(!empty($row->usersInfo->work_phone)):

                        $phone = $row->usersInfo->work_phone;
                        $phone = "<a class='h5' href='tel:{$phone}'>{$phone}</a>";

                        else:

                        $phone = '';

                        endif

                        @endphp

                        <tr>
                          <td>{{++$count}}</td>
                          <td>{{$row->username}}</td>
                          <td>{{$row->designation()->first()->des_name}}</td>
                          <td>{!!$phone!!}</td>
                          <td><span class="badge badge-success user-badge" title="Team Member">Team Member</span></td>
                        </tr>

                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer"></div>
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

</body>

</html>