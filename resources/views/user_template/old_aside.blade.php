<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link bg-white">
    <img src="{{url('')}}/layout/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image" />
    <span class="brand-text font-weight-light">&nbsp;</span>
  </a>
 
  @php
  $profileImg = AppSession::get()->getProfile();
  @endphp

  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(!empty($profileImg))
        <img src="{{$profileImg}}" class="img-circle elevation-2" alt="User Image">
        @else
        <img src="{{url('')}}/layout/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        @endif
      </div>
      <div class="info">
        <a href="{{url('')}}/profile/view" class="d-block">{{AppSession::get()->userName()}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-treeview" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-header">MENU</li>

        @if(AppSession::get()->postId() === 1)

        <li class="nav-item">
          <a href="{{url('')}}/content-writer" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Live Task
            </p>
          </a>
        </li>


        <li class="nav-item {{request()->routeIs('cw.content.*')?'menu-open':''}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Requested Content
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('')}}/content-writer/request/content/list" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>Assign 2 Writer</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{url('')}}/content-writer/content/assigned/list" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>Task Lsit</p>
              </a>
            </li>

          </ul>
        </li>


        @elseif(AppSession::get()->postId() === 2)

        <li class="nav-item">
          <a href="{{url('')}}/designer" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Live Task
            </p>
          </a>
        </li>

        @elseif(AppSession::get()->postId() === 3)

        <li class="nav-item">
          <a href="{{url('')}}/developer" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Live Task
            </p>
          </a>
        </li>

        @elseif(AppSession::get()->postId() === 4)

        <li class="nav-item">
          <a href="{{url('')}}/seo" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Live Task
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{url('')}}/seo/submit-work-report" class="nav-link">
            <i class="nav-icon fas fa-file-excel"></i>
            <p>
              Submit Work Report
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{url('')}}/seo/view-work-report" class="nav-link">
            <i class="nav-icon fas fa-file-excel"></i>
            <p>
              View Work Report
            </p>
          </a>
        </li>


        <li class="nav-item">
          <a href="{{url('')}}/seo/work-report/link-count" class="nav-link">
            <i class="nav-icon fas fa-file-excel"></i>
            <p>
              SEO Link Counts
            </p>
          </a>
        </li>


        <li class="nav-item {{request()->routeIs('seo.order_stats.*')?'menu-open':''}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Order Statistics
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('')}}/seo/order-stats/teams" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>By Teams</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('')}}/seo/order-stats/calender" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>By Calender</p>
              </a>
            </li>
          </ul>
        </li>


        <li class="nav-item {{request()->routeIs('seo.content.*')?'menu-open':''}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Content Request
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('')}}/seo/request/content/new" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>New Request</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('')}}/seo/request/content/list" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>Content List</p>
              </a>
            </li>
          </ul>
        </li>

        @elseif(AppSession::get()->postId() === 5)

        <li class="nav-item">
          <a href="{{url('')}}/human-resource" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Live Task
            </p>
          </a>
        </li>

        @elseif(AppSession::get()->postId() === 8)

        <li class="nav-item">
          <a href="{{url('')}}/back-office" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Live Task
            </p>
          </a>
        </li>

        @endif

        @php

        $id = '';
        $user_id = '';

        $id = AppSession::get()->getAssignId();

        $user_id = AppSession::get()->userId();

        @endphp
        
        @if(empty($id))
        <li class="nav-item {{request()->routeIs('users.assign_task.view')?'menu-open':''}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Assign Task
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{url('')}}/users/assign-task/view" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>View Tasks <span class="badge badge-light" id="badges-assign"></span></p>
              </a>
            </li>
          </ul>
        </li>
        @else
        <li class="nav-item {{request()->routeIs('users.assign-task.*')?'menu-open':''}}" data-id="{{$id}}" data-user-id="{{$user_id}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Assign Task
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <!-- <a href="{{url('')}}/users/assign-task/view" class="nav-link">
                <p><i class="nav-icon fas fa-tasks"></i> View Tasks <span class="badge badge-light" id="badges-assign"></span></p>
              </a> -->


          <ul class="nav nav-treeview" id="assign-notify" data-id="{{$id}}" data-user-id="{{$user_id}}">

            <li class="nav-item">
              <a href="{{url('')}}/users/assign-task/view" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>View Tasks <span class="badge badge-light" id="badges-assign"></span></p>
              </a>
            </li>
          </ul>
        </li>

       
        @endif

        <li class="nav-item {{request()->routeIs('users.feedback.*')?'menu-open':''}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Feedback
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{url('')}}/users/feedback/view" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>View Feedback</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{url('')}}/active-users" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Working Users
            </p>
          </a>
        </li>


        <li class="nav-item">
          <a href="{{url('')}}/attendance/month-view" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              View Attendance
            </p>
          </a>
        </li>

        <li class="nav-item {{request()->routeIs('users.upload-document.*')?'menu-open':''}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Documents
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{url('')}}/users/employee-documents" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>Add Documents</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{url('')}}/notifications" class="nav-link">
            <i class="nav-icon fas fa-bell"></i>
            <p>
              Notifications
            </p>
          </a>
        </li>


        <li class="nav-item {{request()->routeIs('user.profile.*')?'menu-open':''}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Profile
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('')}}/profile/view" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>View Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('')}}/profile/change-password" class="nav-link">
                <i class="nav-icon">&nbsp;</i>
                <p>Change Password</p>
              </a>
            </li>
          </ul>
        </li>


        <li class="nav-item">
          <a href="{{url('')}}/login-to-leave-portal" target="_blank" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Login to Leave Portal
            </p>
          </a>
        </li>


        @if(AppSession::get()->postId() === 4)

        <li class="nav-header">Links for SEOs</li>

        <li class="nav-item">
          <a href="{{url('')}}/seo/team-info" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Team Info</p>
          </a>
        </li>

        @endif


        @if(AppSession::get()->postId() === 4 || AppSession::get()->postId() === 1)

        <li class="nav-item">
          <a href="https://drive.google.com/file/d/1iSRIwJGGlXQETWSNhGYskDRSmQaBXtir/view?usp=sharing" target="_blank" class="nav-link">
            <i class="nav-icon far fa-file-word"></i>
            <p>Project Keywords</p>
          </a>
        </li>
        @endif




        <li class="nav-header">Tools & Software</li>

        @if(AppSession::get()->postId() === 4)

        <li class="nav-item">
          <a href="{{url('')}}/seo/training-docs" class="nav-link">
            <i class="nav-icon far fa-file-alt"></i>
            <p>Training Documents</p>
          </a>
        </li>

        @endif

        <li class="nav-item">
          <a href="https://chrome.google.com/webstore/detail/setupvpn-lifetime-free-vp/oofgbpoabipfcfjapgnbbjjaenockbdp" target="_blank" class="nav-link">
            <i class="nav-icon fab fa-chrome"></i>
            <p>Free VPN For Chrome</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{url('')}}/downloads/tracking-soft/ATAcct609638_1cdmVa150uE-_29607103600.msi" target="_blank" class="nav-link">
            <i class="nav-icon fas fa-file-download"></i>
            <p>Download Software</p>
          </a>
        </li>



        <li class="nav-header">Important Links</li>

        <li class="nav-item">
          <a href="https://drive.google.com/file/d/1erNbNHYbtEL2GZ3RxcKob__-9GZhYoLA/view?usp=sharing" target="_blank" class="nav-link">
            <i class="nav-icon far fa-file-alt"></i>
            <p>Company Policies</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
    <!-- <i class="nav-icon fas fa-columns"></i> -->
  </div>

</aside>