<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{url('')}}/admin/dashboard" class="brand-link bg-white">
    <img src="{{url('')}}/layout/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image" />
    <span class="brand-text font-weight-light">&nbsp;</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar admin-sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3  d-flex">
      <div class="image">
        <img src="{{url('')}}/layout/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{url('')}}/admin/profile/view" class="d-block">Admin</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="{{url('')}}/admin/dashboard" class="nav-link nav-sec0 {{request()->routeIs('admin.dashboard')?'active':''}}">
            <i class="nav-icon fas fa-th-large"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>



        <li class="nav-item menu-open">
          <a href="#" class="nav-link nav-sec1">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Section - I
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ">

            <li class="nav-header">Task Assign</li>
            <li class="nav-item {{request()->routeIs('admin.manage.users.assign_task.user')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Assign Task
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/manage/users/assign-task/user" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>View Task <span class="badge badge-light" id="admin-badges-assignTask"></span></p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Feedback/Complain</li>

            <li class="nav-item {{request()->routeIs('admin.manage.user.feedback.view')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Feedback/Complain
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/manage/users/feedback/view" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>View Feedback <span class="badge badge-light" id="admin-badges-feedback"></span></p>
                  </a>
                </li>


              </ul>
            </li>
            <li class="nav-item {{request()->routeIs('admin.office_expenses')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Office Expenses
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/manage/office-expenses/add-form" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>Add Expenses</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/manage/office-expenses/view" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>View Expenses</p>
                  </a>
                </li>

              </ul>
            </li>



            <li class="nav-header">Work Record</li>


            <li class="nav-item {{request()->routeIs('admin.users_task')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  User Task Info
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/task/content-writer" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Content Writer</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/task/designer" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Designers</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/task/developer" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Developers</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/task/human-resource" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>HRs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/task/back-office" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Back Office</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/task/seo" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>SEOs</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item {{request()->routeIs('admin.work_report.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Work Report
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/work-report/seo" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>SEO Work Report</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview  nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/work-report/seo/duplicate-urls" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Work Report Duplicate URLs</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview  nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/work-report/seo-link-count" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Link Report Count</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Order Menu</li>

            <li class="nav-item {{request()->routeIs('admin.order.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Order Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/manage/add" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Add Order</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/dashboard" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Order Dashboard</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/dashboard/seo-sales-team" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Order By Sales Team</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/report/month-view" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Month Report</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/report/day-view" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Day Report</p>
                  </a>
                </li>

              </ul>
            </li>


            <li class="nav-header">Team and Site</li>

            <li class="nav-item {{request()->routeIs('admin.site_manage.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-globe"></i>
                <p>
                  Site Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/website/manage/relation-with-user" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Assign to Users</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item {{request()->routeIs('admin.manage.site_info')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-globe"></i>
                <p>
                  Website Info
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="{{url('')}}/admin/manage/site-info/list" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>Manage Web Info</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item {{request()->routeIs('admin.seo_team.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Team Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/seo-team/manage/create" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Create Team</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/seo/team-info" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Team Info</p>
                  </a>
                </li>
              </ul>
            </li>



            <li class="nav-item {{request()->routeIs('admin.content.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-file-alt"></i>
                <p>
                  Content On Demand
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/request/content/new" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Request New Content</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/request/content/list" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>List Request Content</p>
                  </a>
                </li>
              </ul>
            </li>


          </ul>
        </li>

        <li class="nav-item menu-open">
          <a href="#" class="nav-link nav-sec2">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Section - II
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">



            <li class="nav-header">Users and Profile</li>


            <li class="nav-item {{request()->routeIs('admin.users.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  User Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/user/add-new" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Add New</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/user/manage" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Manage Users</p>
                  </a>
                </li>

              </ul>
            </li>

            <li class="nav-header">Department Post Management</li>

            <li class="nav-item {{request()->routeIs('admin.department.list')?'menu-open':''}}">
              <a href="#" class="nav-link">
              <i class="far fa-building"></i>
                <p>
                  Department Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/department/list" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>View Department</p>
                  </a>
                </li>

              </ul>
            </li>


            <li class="nav-item {{request()->routeIs('admin.designation.list')?'menu-open':''}}">
              <a href="#" class="nav-link">
              <i class="fas fa-user-shield"></i>
                <p>
                  Designation Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/designation/list" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>View Designation</p>
                  </a>
                </li>

              </ul>
            </li>


            <li class="nav-item {{request()->routeIs('admin.post.list')?'menu-open':''}}">
              <a href="#" class="nav-link">
              <i class="fas fa-user-tie"></i>
                <p>
                  Post Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/post/list" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>View Post</p>
                  </a>
                </li>
              </ul>
            </li>




            <li class="nav-item {{request()->routeIs('admin.users.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
              <i class="fas fa-file-alt"></i>
                <p>
                  Document Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/manage/document/user/approve-status" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>View Documents <span class="badge badge-light" id="badges"></span></p>
                  </a>
                </li>

              </ul>
            </li>

            <li class="nav-item {{request()->routeIs('admin.profile.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Profile
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/profile/view" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>View Profile</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/profile/change-password" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Change Password</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-header">Security</li>

            <li class="nav-item {{request()->routeIs('admin.security.pages.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shield-alt"></i>
                <p>
                  Admin Pages Access
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/security/manage/pages/grant-access" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Grant Access</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-header">Tools</li>


            <li class="nav-item {{request()->routeIs('admin.notification.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-comment-alt"></i>
                <p>
                  Live Notification
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/notification/create" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Create Notification</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/notification/list" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>View Notifications</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/notification/manage/options/notification/add" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Marque Notifications</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item {{request()->routeIs('admin.checklist.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-check-double"></i>
                <p>
                  Checklist
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/checklist/users-group/add" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Users Group</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/checklist/rule/create" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Create Rule</p>
                  </a>
                </li>
              </ul>
            </li>



            <li class="nav-header">Attendance Menu</li>

            <li class="nav-item {{request()->routeIs('admin.attendance.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Attendance
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/attendance/single-user" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>View Attendance</p>
                  </a>
                </li>
              </ul>
            </li>



            <li class="nav-header">Other Portals Login</li>

            <li class="nav-item">
              <a href="{{url('')}}/login-to-leave-portal" target="_blank" class="nav-link ">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>
                  Leave Portal
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{url('')}}/login-to-domain-hosting-portal" target="_blank" class="nav-link">
                <i class="nav-icon fas fa-server"></i>
                <p>
                  Domain & Hosting
                </p>
              </a>
            </li>


            <li class="nav-header">Office Documents</li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-file-alt"></i>
                <p>
                  Office Documents
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a target="_blank" href="https://drive.google.com/file/d/1erNbNHYbtEL2GZ3RxcKob__-9GZhYoLA/view?usp=sharing" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Company Policies</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1hbxYXZ6iTWPpaFR4Sr9O6j-pXTRc_wsxujjgcTJVjWI/edit#gid=1737827973" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>All Employees Phone No.</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1hbxYXZ6iTWPpaFR4Sr9O6j-pXTRc_wsxujjgcTJVjWI/edit#gid=1694098345" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>All Employee Details</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://drive.google.com/drive/folders/1d40OefuiQluEDqI4GYWg8JytsnIxnI2m?usp=sharing" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>All Employee Documents</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1hbxYXZ6iTWPpaFR4Sr9O6j-pXTRc_wsxujjgcTJVjWI/edit#gid=1230952531" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>All Email & Password</p>
                  </a>
                </li>


                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1hbxYXZ6iTWPpaFR4Sr9O6j-pXTRc_wsxujjgcTJVjWI/edit#gid=1771738704" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Social & Other Login</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/10hf628HQsEH78CvmqbayqQDRka61RI0jN5zaxBnMc9c/edit?usp=sharing" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>All Websites List - Info</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1hbxYXZ6iTWPpaFR4Sr9O6j-pXTRc_wsxujjgcTJVjWI/edit#gid=71334254" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Office Expenses</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1j6VidT5iDlekHcKQz46NmHUKnhSrHwjmVXQj54QLcVA/edit?usp=sharing" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Office Equipment</p>
                  </a>
                </li>


              </ul>
            </li>



            <li class="nav-header">Hiring - Applications</li>

            <li class="nav-item {{request()->routeIs('admin.seo_team.*')?'menu-open':''}}">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-file-alt"></i>
                <p>
                  Hiring - Applications
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1DZTwNZMte8mZ8bFvu27OkH_lBRUbawD9jgzwqVSBUPk/edit?usp=sharing" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>SEO</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1JWDOxkPSZKkoGJDP59caewGfF5d-vz-ZM3FXU7GBvok/edit?usp=sharing" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Designer & Developer</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a target="_blank" href="https://docs.google.com/spreadsheets/d/1t1iOZGszuU40zy-3tDTHhDmQqT07gcV5RftlpqT0KMA/edit?usp=sharing" class="nav-link nav-sec3">
                    <i class="fas fa-angle-right"></i>
                    <p>Content Writer</p>
                  </a>
                </li>

              </ul>
            </li>



            <li class="nav-header">Important Links</li>

            <li class="nav-item">
              <a href="{{url('')}}/admin/seo/training-docs" class="nav-link {{request()->routeIs('admin.training_docs')?'active':''}}">
                <i class="nav-icon far fa-file-alt"></i>
                <p>Training Documents</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="https://docs.google.com/spreadsheets/d/1eOHGjwV7AJ1Kp4hNdO8ZC53QkIhdvnk3Ko5nuBE5IX4/edit?usp=sharing" target="_blank" class="nav-link">
                <i class="nav-icon fas fa-shopping-bag"></i>
                <p>Order Record</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="https://drive.google.com/file/d/1iSRIwJGGlXQETWSNhGYskDRSmQaBXtir/view?usp=sharing" target="_blank" class="nav-link">
                <i class="nav-icon far fa-file-word"></i>
                <p>Project Keywords</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="https://analytics.google.com" target="_blank" class="nav-link">
                <i class="nav-icon fab fa-google"></i>
                <p>Google Analytics</p>
              </a>
            </li>
            <br>

          </ul>
        </li>


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>