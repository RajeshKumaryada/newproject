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
        <li class="nav-item">
          <a href="#" class="nav-link nav-sec1">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Section - I
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview"> 
               <li class="nav-header">Work Record</li>                      
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <p>
                          Time Report
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview nav-new">              
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/task/back-office" class="nav-link nav-sec3">
                            <p>Back Office</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/task/content-writer" class="nav-link nav-sec3">
                            <p>Content Writer</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/task/designer" class="nav-link nav-sec3">
                            <p>Designers</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/task/developer" class="nav-link nav-sec3">
                            <p>Developers</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/task/human-resource" class="nav-link nav-sec3">
                            <p>HRs</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/task/seo" class="nav-link nav-sec3">
                            <p>SEOs</p>
                          </a>
                        </li>
                      </ul>
                    </li>


                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <p>
                          Work Report
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview nav-new">
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/work-report/seo" class="nav-link nav-sec3">
                            <p>SEO Work Report</p>
                          </a>
                        </li>   
                         <li class="nav-item">
                          <a href="{{url('')}}/admin/seo-team/manage-work-report/view" class="nav-link nav-sec3">
                            <p>SEO IT Work Report</p>                    
                          </a>
                        </li>         
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/work-report/seo/duplicate-urls" class="nav-link nav-sec3">
                            <p>Duplicate URLs</p>
                          </a>
                        </li> 
                        <li class="nav-item">
                          <a href="{{url('')}}/admin/work-report/seo-link-count" class="nav-link nav-sec3">
                            <p>Link Report Count</p>
                          </a>
                        </li>
                      </ul>
                    </li>

                     <li class="nav-item">
                          <a href="#" class="nav-link">
                            <p>
                              Detailed Report
                              <i class="fas fa-angle-left right"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview nav-new">
                            <li class="nav-item">
                              <a href="#" class="nav-link nav-sec3">
                                <p>Back Office</p>
                              </a>
                            </li>   
                             <li class="nav-item">
                              <a href="#" class="nav-link nav-sec3">
                                <p>Designers</p>                    
                              </a>
                            </li>         
                            <li class="nav-item">
                              <a href="#" class="nav-link nav-sec3">
                                <p>Developers</p>
                              </a>
                            </li> 
                            <li class="nav-item">
                              <a href="#" class="nav-link nav-sec3">
                                <p>HRs</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="#" class="nav-link nav-sec3">
                                <p>Writers</p>
                              </a>
                            </li>
                          </ul>
                        </li>                 
                </li>  


            <li class="nav-header">Order</li>

            <li class="nav-item">
              <a href="#" class="nav-link">                
                <p>
                  Manage Orders
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/manage/add" class="nav-link nav-sec3">
                    <p>Add Order</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/dashboard" class="nav-link nav-sec3">
                    <p>Order Dashboard</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/dashboard/seo-sales-team" class="nav-link nav-sec3">
                    <p>Order By Sales Team</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/report/month-view" class="nav-link nav-sec3">
                    <p>Month Report</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/order/report/day-view" class="nav-link nav-sec3">
                    <p>Day Report</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link nav-sec3">
                    <p>Referral Links</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Teams & Sites</li>
            <li class="nav-item">
              <a href="#" class="nav-link">              
                <p>
                  Manage Teams
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/seo-team/manage/create" class="nav-link nav-sec3">
                    <p>Manage</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{url('')}}/admin/seo/team-info" class="nav-link nav-sec3">
                    <p>Team</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <p>
                  Manage Websites
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new"> 
                <li class="nav-item">
                  <a href="{{url('')}}/admin/manage/site-info/list" class="nav-link">
                    <i class="nav-icon"></i>
                    <p>Manage</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/website/manage/relation-with-user" class="nav-link nav-sec3">
                    <p>Assign</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <p>
                  Website Info                 
                </p>
              </a>          
            </li>
            <li class="nav-header">Content</li>
            <li class="nav-item">
              <a href="#" class="nav-link">               
                <p>
                  Manage Content
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
               <li class="nav-item">
                  <a href="{{url('')}}/admin/request/content/new" class="nav-link nav-sec3">
                    <p>Request New Content</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/request/content/list" class="nav-link nav-sec3">
                    <p>List Request Content</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Content Count</li>
            <li class="nav-item">
              <a href="#" class="nav-link">               
                <p>
                  View Content Count
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
               <li class="nav-item">
                  <a href="{{url('')}}/admin/work-report-cw/view" class="nav-link nav-sec3">
                    <p>View Content</p>
                  </a>
                </li>
                
              </ul>
            </li>

           <li class="nav-header">Assign Task</li>
            <li class="nav-item {{request()->routeIs('admin.manage.users.assign_task.user')?'':''}}">
              <a href="{{url('')}}/admin/manage/users/assign-task/user" class="nav-link">
                 <p>View Task <span class="badge badge-light" id="admin-badges-assignTask"></span></p>
              </a>               
            </li>
            </ul>
           </li>


        <li class="nav-item">
          <a href="#" class="nav-link nav-sec2">
          <i class="nav-icon fas fa-tasks"></i>
            <p>
              Section - II
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-header">Employees</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <p>
                 Manage Employees
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/user/add-new" class="nav-link nav-sec3">
                    <p>Add New</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/user/manage" class="nav-link nav-sec3">
                    <p>Manage Users</p>
                  </a>
                </li>
                 <li class="nav-item">
                  <a href="#" class="nav-link nav-sec3">
                    <p>Details</p>
                  </a>
                </li>
                 <li class="nav-item">
                  <a href="#" class="nav-link nav-sec3">
                    <p>Referral Status</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="{{url('')}}/admin/manage/document/user/approve-status" class="nav-link">              
                 <p>Document Approval <span class="badge badge-light" id="badges"></span></p>
              </a>      
            </li>

          <li class="nav-header"> Department & Post </li>              
              <li class="nav-item">
                <a href="{{url('')}}/admin/department/list" class="nav-link">
                  <p>Department</p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="{{url('')}}/admin/post/list" class="nav-link nav-sec3">
                  <p>Post</p>
                </a>
              </li>             
              <li class="nav-item">
                <a href="{{url('')}}/admin/designation/list" class="nav-link">               
                  <p>Designation</p>
                </a>
              </li>           
           

            <li class="nav-header">Admin Profile</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <p>
                  Profile
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview nav-new">
                <li class="nav-item">
                  <a href="{{url('')}}/admin/profile/view" class="nav-link nav-sec3">
                    <p>View Profile</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{url('')}}/admin/profile/change-password" class="nav-link nav-sec3">
                    <p>Change Password</p>
                  </a>
                </li>
              </ul>
            </li>

             <li class="nav-header">Tools</li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">                     
                      <p>
                        Live Notification
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview nav-new">
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/notification/create" class="nav-link nav-sec3">
                          <p>Create</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/notification/list" class="nav-link nav-sec3">
                          <p>View</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/notification/manage/options/notification/add" class="nav-link nav-sec3">
                          <p>Marque Notifications</p>
                        </a>
                      </li>
                    </ul>
                  </li>                
                  <li class="nav-item">
                    <a href="#" class="nav-link">                      
                      <p>
                        Alerts - Tracking
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview nav-new">
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/manage/users/alarm/create" class="nav-link nav-sec3">
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/manage/users/alarm/get-details" class="nav-link nav-sec3">
                          <p>View Alarms</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">                    
                      <p>
                        Checklist
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview nav-new">
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/checklist/users-group/add" class="nav-link nav-sec3">
                          <p>Users Group</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/checklist/rule/create" class="nav-link nav-sec3">
                          <p>Create Rule</p>
                        </a>
                      </li>
                    </ul>
                  </li>

                 
                  <li class="nav-header">Leaves</li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">                     
                      <p>
                        Manage Leaves
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview nav-new">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <p>Applications</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <p>Record</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <p>Holidays</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <p>Allotment</p>
                        </a>
                      </li>                    
                    </ul>
                  </li>  

                <li class="nav-header">Attendance</li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">                     
                      <p>
                        View Attendance
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview nav-new">
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/attendance/single-user" class="nav-link nav-sec3">
                          <p>Monthly </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link nav-sec3">
                          <p>Daily</p>
                        </a>
                      </li>
                    </ul>
                  </li> 

                  <li class="nav-header">Feedback/compalin</li>                
                    <li class="nav-item {{request()->routeIs('admin.manage.user.feedback.view')?'':''}}">
                      <a href="{{url('')}}/admin/manage/users/feedback/view" class="nav-link">
                        <p>View Feedback <span class="badge badge-light" id="admin-badges-feedback"></span></p>
                      </a>   
                    </li> 
 

                  <li class="nav-header">Salary</li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">                     
                        <p>
                          Manage Salary
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview nav-new">                    
                      <li class="nav-item">
                        <a href="{{url('')}}/admin/attendance/single-user" class="nav-link nav-sec3">
                          <p>All Employees </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link nav-sec3">
                          <p>Adjustments</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link nav-sec3">
                          <p>Salary Slip</p>
                        </a>
                      </li>
                    </ul>
                  </li> 

                 <li class="nav-header"> Secutiry </li>
                  <li class="nav-item">
                    <a href="{{url('')}}/admin/security/manage/pages/grant-access" class="nav-link">
                      <p>Admin Pages Access</p>
                    </a>                     
                  </li>

                  <li class="nav-header"> Other Portals </li>                   
                      <li class="nav-item">
                        <a href="{{url('')}}/login-to-leave-portal" target="_blank" class="nav-link ">
                            <p>Leave Portal</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{url('')}}/login-to-domain-hosting-portal" target="_blank" class="nav-link">                
                          <p>Domain & Hosting </p> 
                        </a>
                      </li>                     
                  </li>  
               
                  <li class="nav-header"> Office Expenses </li>  
                    <li class="nav-item">
                      <a href="{{url('')}}/admin/manage/office-expenses/add-form" class="nav-link">                   
                        <p>Add</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{url('')}}/admin/manage/office-expenses/view" class="nav-link">                   
                        <p>View</p>
                      </a>
                  </li>   
           
                 <li class="nav-header">  Office Documents </li>  
                  <li class="nav-item">
                    <a target="_blank" href="https://docs.google.com/spreadsheets/d/1hbxYXZ6iTWPpaFR4Sr9O6j-pXTRc_wsxujjgcTJVjWI/edit#gid=1230952531" class="nav-link nav-sec3">
                      <p>All Email & Password</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a target="_blank" href="https://docs.google.com/spreadsheets/d/1hbxYXZ6iTWPpaFR4Sr9O6j-pXTRc_wsxujjgcTJVjWI/edit#gid=1771738704" class="nav-link nav-sec3">
                      <p>Social & Other Login</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a target="_blank" href="https://docs.google.com/spreadsheets/d/1j6VidT5iDlekHcKQz46NmHUKnhSrHwjmVXQj54QLcVA/edit?usp=sharing" class="nav-link nav-sec3">
                      <p>Office Equipment</p>
                    </a>
                  </li>   

                <li class="nav-header">  Hiring Applications </li>  
                  <li class="nav-item">
                    <a target="_blank" href="https://docs.google.com/spreadsheets/d/1DZTwNZMte8mZ8bFvu27OkH_lBRUbawD9jgzwqVSBUPk/edit?usp=sharing" class="nav-link">
                      <p>SEO</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a target="_blank" href="https://docs.google.com/spreadsheets/d/1JWDOxkPSZKkoGJDP59caewGfF5d-vz-ZM3FXU7GBvok/edit?usp=sharing" class="nav-link">
                      <p>Designer & Developer</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a target="_blank" href="https://docs.google.com/spreadsheets/d/1t1iOZGszuU40zy-3tDTHhDmQqT07gcV5RftlpqT0KMA/edit?usp=sharing" class="nav-link">
                       <p>Content Writer</p>
                    </a>
                  </li> 
           
                <li class="nav-header"> Important Links </li>  
                <li class="nav-item">
                  <a href="{{url('')}}/admin/seo/training-docs" class="nav-link {{request()->routeIs('admin.training_docs')?'active':''}}">
                     <p>Training Documents</p>
                  </a>
                </li>     
                <li class="nav-item">
                  <a href="https://drive.google.com/file/d/1iSRIwJGGlXQETWSNhGYskDRSmQaBXtir/view?usp=sharing" target="_blank" class="nav-link">                
                    <p>Project Keywords</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="https://analytics.google.com" target="_blank" class="nav-link">                
                    <p>Google Analytics</p>
                  </a>
                </li>  
          </ul>
        </li>  
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>