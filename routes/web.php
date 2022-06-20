<?php

use App\Http\Controllers\Admin\AssignTask\AssignTaskCtrl;
use App\Http\Controllers\Admin\Attendance\AttendanceByDateCtrl;
use App\Http\Controllers\Admin\Attendance\AttendanceCtrl as AdminAttendanceCtrl;
use App\Http\Controllers\Admin\Checklist\ChecklistCtrl;
use App\Http\Controllers\Admin\Checklist\ChecklistGroupCtrl as AdminChecklistGroupCtrl;
use App\Http\Controllers\Admin\CompanyPoliciesCtrl;
use App\Http\Controllers\Admin\UsersCtrl as AdminUserCtrl;
use App\Http\Controllers\Admin\DashboardCtrl as AdminDashboardCtrl;
use App\Http\Controllers\Admin\Feedback\FeedbackCtrl;
use App\Http\Controllers\Admin\LinkReportCtrl as AdminLinkReportCtrl;
use App\Http\Controllers\Admin\LoginAsUser\LoginAsUserCtrl;
use App\Http\Controllers\Admin\LoginLocation\LoginLocationCtrl;
use App\Http\Controllers\Admin\NotificationCtrl as AdminNotificationCtrl;
use App\Http\Controllers\Admin\OfficeExpenses\OfficeExpensesCtrl;
use App\Http\Controllers\Admin\OrderManagement\OrderDashboardCtrl as AdminOrderDashboardCtrl;
use App\Http\Controllers\Admin\OrderManagement\OrderManageCtrl as AdminOrderManageCtrl;
use App\Http\Controllers\Admin\OrderManagement\OrderReportMonthCtrl as AdminOrderReportMonthCtrl;
use App\Http\Controllers\Admin\OrderManagement\OrderReportDayCtrl as AdminOrderReportDayCtrl;
use App\Http\Controllers\Admin\PagesAccess\PagesAccessCtrl;
use App\Http\Controllers\Admin\SeoWorkDuplicateURLCtrl as AdminSeoWorkDuplicateURLCtrl;
use App\Http\Controllers\Admin\SeoTeam\SeoTeamCtrl as AdminSeoTeamCtrl;
use App\Http\Controllers\Admin\SiteManagement\SiteUserRelationCtrl;
use App\Http\Controllers\Admin\UserAlarm\UserAlarmCtrl;
use App\Http\Controllers\Admin\Users\UserInfoCtrl as AdminUserInfoCtrl;
use App\Http\Controllers\Admin\Users\UsersApproveStatusDocCtrl;
use App\Http\Controllers\Admin\UserTaskFinishCtrl as AdminUserTaskFinishCtrl;
use App\Http\Controllers\Admin\UserTaskInfoCtrl as AdminUserTaskInfoCtrl;
use App\Http\Controllers\Admin\UserWorkReportCtrl as AdminUserWorkReportCtrl;
use App\Http\Controllers\Admin\WorkReportCWCtrl;
use App\Http\Controllers\Attendance\AttendanceMonthCtrl;
use App\Http\Controllers\ContentOnDemand\Admin\RequestNewContentCtrl as AdminRequestNewContentCtrl;
use App\Http\Controllers\ContentOnDemand\Admin\WriterTeamLeader as AdminWriterTeamLeader;
use App\Http\Controllers\ContentOnDemand\Writer\ContentEditorCtrl;
use App\Http\Controllers\ContentOnDemand\Seo\RequestNewContentCtrl;
use App\Http\Controllers\ContentOnDemand\WordTextDocCtrl;
use App\Http\Controllers\ContentOnDemand\WriterLeader\WriterTeamLeader;
use App\Http\Controllers\ContentOnDemand\Writer\WriterTeamMemberCtrl;
use App\Http\Controllers\DepartmentManager\DepartmentCtrl;
use App\Http\Controllers\DesignationManager\DesignationCtrl;
use App\Http\Controllers\EmployeeManagement\EmpDepartmentCtrl;
use App\Http\Controllers\EmployeeManagement\EmpDesignationCtrl;
use App\Http\Controllers\EmployeeManagement\EmpPostCtrl;
use App\Http\Controllers\EmployeeManagement\UserCtrl as EmpUserCtrl;
use App\Http\Controllers\LocationTrace\LocationTraceCtrl;
use App\Http\Controllers\Login\LoginCtrl;
use App\Http\Controllers\Login\LoginAdminAccess;
use App\Http\Controllers\Login\LoginOtherPortal;
use App\Http\Controllers\Login\LogoutCtrl;
use App\Http\Controllers\Login\UserLoginLocationCtrl;
use App\Http\Controllers\ManageOptions\ManageOptionsCtrl;
use App\Http\Controllers\Notification\NoticeBoardCtrl;
use App\Http\Controllers\Notification\NotificationCtrl;
use App\Http\Controllers\OrderStatistics\OrderStatsCtrl;
use App\Http\Controllers\PostManager\PostCtrl;
use App\Http\Controllers\SeoTask\SEOTaskCtrl;
use App\Http\Controllers\ShowChecklist\ShowChecklistCtrl;
use App\Http\Controllers\UserProfile\ProfileCtrl;
use App\Http\Controllers\UserProfile\ProfileManagerCtrl;
use App\Http\Controllers\UserProfile\SalaryCtrl;
use App\Http\Controllers\UserProfile\UserAddressCtrl;
use App\Http\Controllers\UserProfile\UserBankInfoCtrl;
use App\Http\Controllers\Users\AlarmCtrl;
use App\Http\Controllers\Users\UsersDocumentCtrl;
use App\Http\Controllers\Users\UsersPolicyCtrl;
use App\Http\Controllers\UsersAssignTaskCtrl;
use App\Http\Controllers\UsersFeedback\UsersFeedbackCtrl;
use App\Http\Controllers\Website\WebsiteCtrl;
use App\Http\Controllers\WorkingUsers\WorkingUsersCtrl;
use App\Http\Controllers\WorkPortal\BackOffice\BackOfficeTaskCtrl;
use App\Http\Controllers\WorkPortal\ContentWriter\ContentWriterCtrl;
use App\Http\Controllers\WorkPortal\ContentWriter\ContentWriterTaskCtrl;
use App\Http\Controllers\WorkPortal\Designer\DesignerCtrl;
use App\Http\Controllers\WorkPortal\Designer\DesignerTaskCtrl;
use App\Http\Controllers\WorkPortal\Developer\DeveloperCtrl;
use App\Http\Controllers\WorkPortal\Developer\DeveloperTaskCtrl;
use App\Http\Controllers\WorkPortal\HumanResource\HumanResourceCtrl;
use App\Http\Controllers\WorkPortal\HumanResource\HumanResourceTaskCtrl;
use App\Http\Controllers\WorkPortal\SeoExecutive\LinkReportCtrl;
use App\Http\Controllers\WorkPortal\SeoExecutive\OrderDashCtrl;
use App\Http\Controllers\WorkPortal\SeoExecutive\SeoExecutiveCtrl;
use App\Http\Controllers\WorkPortal\SeoExecutive\SeoExecutiveTaskCtrl;
use App\Http\Controllers\WorkPortal\SeoExecutive\SeoSubmitWorkReportCtrl;
use App\Http\Controllers\WorkPortal\SeoExecutive\SeoTaskListCtrl;
use App\Http\Controllers\WorkPortal\SeoExecutive\SeoTeamCtrl;
use App\Http\Controllers\WorkPortal\SeoExecutive\SeoVieWorkReportCtrl;
use App\Http\Middleware\AppValidateLogin;
use App\Http\Middleware\ChecklistAccess\EnableChecklist;
use App\Http\Middleware\CheckLoginPageSession;
use App\Http\Middleware\CheckUserWorkPost;
use App\Http\Middleware\ManagePageAccess\AdminPages;
use App\Http\Middleware\ManagePageAccess\BackOfficePages;
use App\Http\Middleware\ManagePageAccess\ContentWriterPages;
use App\Http\Middleware\ManagePageAccess\DesignerPages;
use App\Http\Middleware\ManagePageAccess\DeveloperPages;
use App\Http\Middleware\ManagePageAccess\HumanResourcePages;
use App\Http\Middleware\ManagePageAccess\SeoPages;
use App\Mail\UserAdded;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', [LoginCtrl::class, 'index'])->middleware([CheckLoginPageSession::class]);
Route::post('ajax/auth/user/login', [LoginCtrl::class, 'authLogin'])->middleware([CheckLoginPageSession::class]);

Route::post('ajax/update/lat-lon-location', [LocationTraceCtrl::class, 'updateLocation']);

//validate login, then available for use
Route::middleware([AppValidateLogin::class])->group(function () {

  //show checklist
  Route::get('checklist/verify', [ShowChecklistCtrl::class, 'show']);
  Route::post('ajax/checklist/verify', [ShowChecklistCtrl::class, 'verify']);



  //notice board msg
  Route::get('ajax/notice-board-msg', [NoticeBoardCtrl::class, 'fetchNotice']);


  Route::get('login-success', function () {
    // return "Done";
  })->middleware([CheckUserWorkPost::class]);

  Route::get('logout', [LogoutCtrl::class, 'index']);

  //user notification
  Route::get('notifications', [NotificationCtrl::class, 'viewListForUser']);
  Route::get('ajax/notifications/fetch-list', [NotificationCtrl::class, 'fetchListForUser']);
  Route::get('ajax/fetch-new-notification', [NotificationCtrl::class, 'checkForUser']);
  Route::post('ajax/notifications/update-last-seen', [NotificationCtrl::class, 'updateLastSeenNotification']);


  //user end active users
  Route::get('active-users', [WorkingUsersCtrl::class, 'viewActiveUsers']);
  Route::get('ajax/active-users', [WorkingUsersCtrl::class, 'getWorkingUsersTime']);


  //user profile
  Route::get('profile/view', [ProfileCtrl::class, 'viewProfile'])->name('user.profile.view');
  Route::get('profile/change-password', [ProfileCtrl::class, 'viewChangePassword'])->name('user.profile.password');
  Route::post('ajax/profile/change-password', [ProfileManagerCtrl::class, 'changePassword']);

  Route::get('attendance/month-view', [AttendanceMonthCtrl::class, 'viewUserMonthRecord']);
  Route::post('ajax/attendance/month-view', [AttendanceMonthCtrl::class, 'fetchUserMonthRecord']);

  //loging to other portals
  Route::get('login-to-leave-portal', [LoginOtherPortal::class, 'leavePortal']);

  //loging to Admin Access
  Route::get('admin-access-pages', [LoginAdminAccess::class, 'getAdminPages']);
  Route::get('login-to-admin-access/{page}', [LoginAdminAccess::class, 'loginToAdminAccess']);




  //enable checklist
  Route::middleware([EnableChecklist::class])->group(function () {


    Route::middleware([DeveloperPages::class])->group(function () {
      //Developer
      Route::get('developer', [DeveloperCtrl::class, 'index']);
      Route::post('ajax/developer/task/add', [DeveloperTaskCtrl::class, 'addTask']);
      Route::post('ajax/developer/task/finish', [DeveloperTaskCtrl::class, 'finishTask']);
      Route::get('ajax/developer/task/list', [DeveloperTaskCtrl::class, 'getTodayTaskList']);
    });



    Route::middleware([DesignerPages::class])->group(function () {
      //Designer
      Route::get('designer', [DesignerCtrl::class, 'index']);
      Route::post('ajax/designer/task/add', [DesignerTaskCtrl::class, 'addTask']);
      Route::post('ajax/designer/task/finish', [DesignerTaskCtrl::class, 'finishTask']);
      Route::get('ajax/designer/task/list', [DesignerTaskCtrl::class, 'getTodayTaskList']);
    });



    Route::middleware([SeoPages::class])->group(function () {
      //SEO
      Route::get('seo', [SeoExecutiveCtrl::class, 'index']);
      Route::post('ajax/seo/task/add', [SeoExecutiveTaskCtrl::class, 'addTask']);
      Route::post('ajax/seo/task/finish', [SeoExecutiveTaskCtrl::class, 'finishTask']);
      Route::get('ajax/seo/task/list', [SeoExecutiveTaskCtrl::class, 'getTodayTaskList']);
      Route::get('ajax/seo/seo-task-list', [SeoTaskListCtrl::class, 'getList']);


      //SEO submit work report
      Route::get('seo/submit-work-report', [SeoSubmitWorkReportCtrl::class, 'viewForm']);
      Route::get('ajax/seo/fetch-work-report', [SeoSubmitWorkReportCtrl::class, 'fetchWorkReport']);
      Route::post('ajax/seo/submit-work-report', [SeoSubmitWorkReportCtrl::class, 'submitReportViaForm']);
      Route::post('ajax/seo/submit-work-report-excel', [SeoSubmitWorkReportCtrl::class, 'submitReportViaExcel']);

      Route::get('seo/submit-work-report/url-answer', [SeoSubmitWorkReportCtrl::class, 'viewDuplicateUrlAnswer']);
      Route::post('ajax/seo/submit-work-report/url-answer', [SeoSubmitWorkReportCtrl::class, 'submitDuplicateUrlAnswer']);

      Route::get('seo/view-work-report', [SeoVieWorkReportCtrl::class, 'viewForm']);
      Route::get('ajax/seo/view-work-report/user-list/seo', [SeoVieWorkReportCtrl::class, 'fetchUsersByPost']);
      Route::get('ajax/seo/view-work-report/task-list/seo', [SeoVieWorkReportCtrl::class, 'fetchTaskList']);
      Route::post('ajax/seo/view-work-report/fetch', [SeoVieWorkReportCtrl::class, 'fetchWorkReort']);


      Route::get('seo/training-docs', function () {
        return view('work_portal.seo_executive.training_docs');
      })->name('seo_training_docs');

      // Route::get('seo/team-info', function () {
      //   return view('work_portal.seo_executive.team_info');
      // })->name('seo_team');

      Route::get('seo/team-info', [SeoTeamCtrl::class, 'viewSeoTeam'])->name('seo_team');



      //SEO Order Stats
      Route::get('seo/order-stats/calender', [OrderDashCtrl::class, 'viewStatsByCalender'])->name('seo.order_stats.calender');

      Route::post('ajax/seo/order-stats/calender-year', [OrderStatsCtrl::class, 'fetchYearSales']);

      Route::post('ajax/seo/order-stats/calender-month', [OrderStatsCtrl::class, 'fetchMonthSales']);

      Route::post('ajax/seo/order-stats/calender-year-users', [OrderStatsCtrl::class, 'fetchYearSalesUser']);

      Route::post('ajax/seo/order-stats/calender-month-users', [OrderStatsCtrl::class, 'fetchMonthSalesUser']);


      //SEO - Order Stats
      Route::get('seo/order-stats/teams', [OrderDashCtrl::class, 'viewStatsByTeams'])->name('seo.order_stats.teams');
      Route::post('ajax/seo/order-stats/teams', [OrderStatsCtrl::class, 'fetchMonthOrderBySalesTeam']);


      //SEO - Link count
      Route::get('seo/work-report/link-count', [LinkReportCtrl::class, 'viewSeoLinkReport'])->name('admin.work_report.link_count');
      Route::post('ajax/seo/work-report/link-count', [AdminLinkReportCtrl::class, 'seoLinkReport']);
      Route::post('ajax/seo/work-report/link-details', [AdminLinkReportCtrl::class, 'seoLinkDetails']);



      //request new content by seo
      Route::get('seo/request/content/new', [RequestNewContentCtrl::class, 'viewDemandNewBySeo'])->name('seo.content.new');
      Route::post('ajax/seo/request/content/new', [RequestNewContentCtrl::class, 'saveDemandNewBySeo']);
      Route::post('ajax/seo/request/content/list/delete', [RequestNewContentCtrl::class, 'deleteRequestedContent']);

      //request content list for seo
      Route::get('seo/request/content/list', [RequestNewContentCtrl::class, 'viewRequestedContentList'])->name('seo.content.list');
      Route::get('ajax/seo/request/content/list', [RequestNewContentCtrl::class, 'fetchRequestedContentList']);
      Route::post('ajax/seo/request/content/list/get-remarks', [RequestNewContentCtrl::class, 'fetchContentRemarks']);

      //request content preview for seo
      Route::get('seo/request/content/{pId}/preview', [RequestNewContentCtrl::class, 'viewContentPreview'])->whereNumber('pId')->name('seo.content.preview');;
      Route::post('ajax/seo/request/content/preview', [RequestNewContentCtrl::class, 'getContentPreview']);
      Route::post('ajax/seo/request/content/preview/submit-remark', [RequestNewContentCtrl::class, 'submitRemark']);

      /**
       * Get Seo Download file
       */
      Route::get('seo/content/user/preview/{id}', [WordTextDocCtrl::class, 'exportDocsFile'])->name('export-the-docx');
    });




    Route::middleware([ContentWriterPages::class])->group(function () {
      //Content Writer
      Route::get('content-writer', [ContentWriterCtrl::class, 'index']);
      Route::post('ajax/content-writer/task/add', [ContentWriterTaskCtrl::class, 'addTask']);
      Route::post('ajax/content-writer/task/finish', [ContentWriterTaskCtrl::class, 'finishTask']);
      Route::get('ajax/content-writer/task/list', [ContentWriterTaskCtrl::class, 'getTodayTaskList']);



      //content writer content list - team leader
      Route::get('content-writer/request/content/list', [WriterTeamLeader::class, 'viewAssignContent'])->name('cw.content.list');
      Route::get('ajax/content-writer/request/content/list', [WriterTeamLeader::class, 'fetchRequestedContentList']);
      Route::post('ajax/content-writer/request/content/list/get-remarks', [WriterTeamLeader::class, 'fetchContentRemarks']);
      Route::post('ajax/content-writer/request/content/list/approve', [WriterTeamLeader::class, 'approveContent']);



      //content assigned to writer by - team leader
      Route::get('content-writer/request/content/{contentId}/assign', [WriterTeamLeader::class, 'viewEditAssignContent'])->name('cw.content.assign');
      Route::post('ajax/content-writer/request/content/assign/save', [WriterTeamLeader::class, 'assignContentToWriter']);


      //request content preview for - Team Leader
      Route::get('content-writer/request/content/{pId}/preview', [WriterTeamLeader::class, 'viewContentPreview'])->whereNumber('pId')->name('cw.content.preview');;
      Route::post('ajax/content-writer/request/content/preview', [WriterTeamLeader::class, 'getContentPreview']);
      Route::post('ajax/content-writer/request/content/preview/submit-remark', [WriterTeamLeader::class, 'submitRemark']);

      Route::get('ajax/content-writer/content-leader/notification/badge', [WriterTeamLeader::class, 'notificationBadge']);

      //Preview doc
      Route::get('content/user/preview/{id}', [WordTextDocCtrl::class, 'exportDocsFile'])->name('export-the-docx');


      //writting task for writers
      Route::get('content-writer/content/assigned/list', [WriterTeamMemberCtrl::class, 'viewTaskList'])->name('cw.content.assigned_task');
      Route::get('ajax/content-writer/content/assigned/list', [WriterTeamMemberCtrl::class, 'fetchTaskList']);
      Route::post('ajax/content-writer/content/assigned/list/get-remarks', [WriterTeamMemberCtrl::class, 'fetchContentRemarks']);
      Route::post('ajax/content-writer/content/assigned/edit/submit-remark', [WriterTeamMemberCtrl::class, 'submitRemark']);


      //writer Editor save/update/draft
      Route::get('content-writer/content/assigned/{taskId}/edit', [ContentEditorCtrl::class, 'viewForContentEditor'])->whereNumber('userId')->name('cw.content.assigned_edit');

      Route::post('ajax/content-writer/content/assigned/edit/save', [ContentEditorCtrl::class, 'saveFinalContent']);

      Route::post('ajax/content-writer/assigned/edit/start', [ContentEditorCtrl::class, 'startEditing']);
      Route::post('ajax/content-writer/assigned/edit/auto-save', [ContentEditorCtrl::class, 'autoSaveContent']);
      Route::post('ajax/content-writer/assigned/edit/save', [ContentEditorCtrl::class, 'saveContent']);
      Route::post('ajax/content-writer/assigned/edit/draft-save', [ContentEditorCtrl::class, 'draftSaveContent']);
      Route::post('ajax/content-writer/assigned/edit/add-count-data', [ContentEditorCtrl::class, 'addCountData']);
    });


    Route::middleware([HumanResourcePages::class])->group(function () {
      //Human Resource
      Route::get('human-resource', [HumanResourceCtrl::class, 'index']);
      Route::post('ajax/human-resource/task/add', [HumanResourceTaskCtrl::class, 'addTask']);
      Route::post('ajax/human-resource/task/finish', [HumanResourceTaskCtrl::class, 'finishTask']);
      Route::get('ajax/human-resource/task/list', [HumanResourceTaskCtrl::class, 'getTodayTaskList']);
    });


    Route::middleware([BackOfficePages::class])->group(function () {
      //Back Office
      Route::get('back-office', [BackOfficeTaskCtrl::class, 'index']);
      Route::post('ajax/back-office/task/add', [BackOfficeTaskCtrl::class, 'addTask']);
      Route::post('ajax/back-office/task/finish', [BackOfficeTaskCtrl::class, 'finishTask']);
      Route::get('ajax/back-office/task/list', [BackOfficeTaskCtrl::class, 'getTodayTaskList']);
    });


    //middleware EnableChecklist
  });



  //:::::::::::::::::::::::::::::::::::::::::::::::::::
  // Admin Pages
  //:::::::::::::::::::::::::::::::::::::::::::::::::::

  Route::middleware([AdminPages::class])->group(function () {

    //loging to other portals
    Route::get('login-to-domain-hosting-portal', [LoginOtherPortal::class, 'domainHostingPortal']);

    Route::get('admin/seo/training-docs', function () {
      return view('admin.static.seo_training_docs');
    })->name('admin.training_docs');


    // //Admin Pages Access Manger - Routes
    // Route::get('admin/security/manage/pages/grant-access', [PagesAccessCtrl::class, 'viewForGrantAccess'])->name('admin.security.pages.grant_access');
    // Route::post('ajax/admin/security/manage/pages/grant-access', [PagesAccessCtrl::class, 'insertGrantAccess']);

    //Admin Pages Access Manger - Routes
    Route::get('admin/security/manage/pages/grant-access', [PagesAccessCtrl::class, 'viewForGrantAccess'])->name('admin.security.pages.grant_access');
    Route::post('ajax/admin/security/manage/pages/grant-access', [PagesAccessCtrl::class, 'insertGrantAccess']);
    Route::get('ajax/admin/security/manage/pages/grant-access/list', [PagesAccessCtrl::class, 'accessList']);
    Route::post('ajax/admin/security/manage/pages/grant-access/delete', [PagesAccessCtrl::class, 'deleteAccess']);
    Route::post('ajax/admin/security/manage/pages/grant-access/user-delete', [PagesAccessCtrl::class, 'deleteAccessUser']);


    //Admin - Dashboard
    Route::get('admin/dashboard', [AdminDashboardCtrl::class, 'index'])->name('admin.dashboard');
    // Route::get('ajax/admin/working-users', [AdminDashboardCtrl::class, 'getWorkingUsers']);
    Route::get('ajax/admin/working-users', [AdminDashboardCtrl::class, 'getWorkingUsersTime']);

    Route::get('admin/dashboard/filter-by-date', [AttendanceByDateCtrl::class, 'getDateEmployeeForm']);
    Route::post('ajax/admin/dashboard/filter-by-date', [AttendanceByDateCtrl::class, 'getDateEmployeeActive']);


    //Admin - user task info
    Route::get('admin/task/{post}', [AdminUserTaskInfoCtrl::class, 'usersTask'])->where('post', '[a-z\-]+')->name('admin.users_task');
    Route::get('ajax/admin/task/users/{post}', [AdminUserTaskInfoCtrl::class, 'usersByPost'])->where('post', '[a-z\-]+');
    Route::post('ajax/admin/task/fetch', [AdminUserTaskInfoCtrl::class, 'getTaskList']);
    Route::post('ajax/admin/task/content-writer', [AdminUserTaskInfoCtrl::class, 'cwTaskList']);

    //Admin - user task info finish
    Route::post('ajax/admin/task/developer/finish', [AdminUserTaskFinishCtrl::class, 'developerTask']);
    Route::post('ajax/admin/task/seo/finish', [AdminUserTaskFinishCtrl::class, 'seoTask']);
    Route::post('ajax/admin/task/content-writer/finish', [AdminUserTaskFinishCtrl::class, 'contentWriterTask']);
    Route::post('ajax/admin/task/designer/finish', [AdminUserTaskFinishCtrl::class, 'designerTask']);
    Route::post('ajax/admin/task/human-resource/finish', [AdminUserTaskFinishCtrl::class, 'humanResourceTask']);
    Route::post('ajax/admin/task/back-office/finish', [AdminUserTaskFinishCtrl::class, 'backOfficeTask']);


    //Admin - Link count
    Route::get('admin/work-report/seo-link-count', [AdminLinkReportCtrl::class, 'viewSeoLinkReport'])->name('admin.work_report.link_count');
    Route::post('ajax/admin/work-report/seo-link-count', [AdminLinkReportCtrl::class, 'seoLinkReport']);
    Route::post('ajax/admin/work-report/seo-link-details', [AdminLinkReportCtrl::class, 'seoLinkDetails']);

    //Admin Work Repot
    Route::get('admin/work-report/{post}', [AdminUserWorkReportCtrl::class, 'viewWorkReport'])->where('post', '[a-z\-]+')->name('admin.work_report.list');
    Route::get('ajax/admin/work-report/user-list/{post}', [AdminUserWorkReportCtrl::class, 'fetchUsersByPost'])->where('post', '[a-z\-]+');
    Route::get('ajax/admin/work-report/seo-task-list', [AdminUserWorkReportCtrl::class, 'fetchTaskList']);
    Route::post('ajax/admin/work-report/fetch', [AdminUserWorkReportCtrl::class, 'fetchWorkReort']);

    Route::get('admin/work-report/seo-task-images/{img_id}', [AdminUserWorkReportCtrl::class, 'viewSeoTaskImages']);
    Route::get('admin/work-report/images/render/{folder}/{img_id}', [AdminUserWorkReportCtrl::class, 'renderSeoTaskImage']);

    //SEO Work Duplicate URLs 
    Route::get('admin/work-report/seo/duplicate-urls', [AdminSeoWorkDuplicateURLCtrl::class, 'viewDuplicateUrl'])->name('admin.work_report.duplicate_url');
    Route::get('ajax/admin/work-report/seo/duplicate-urls', [AdminSeoWorkDuplicateURLCtrl::class, 'viewDuplicateUrlData']);
    Route::post('ajax/admin/work-report/seo/duplicate-urls-more', [AdminSeoWorkDuplicateURLCtrl::class, 'viewDuplicateUrlDataMore']);
    Route::post('ajax/admin/work-report/seo/duplicate-urls-form', [AdminSeoWorkDuplicateURLCtrl::class, 'viewDuplicateUrlDataForm']);
    Route::post('ajax/admin/work-report/seo/duplicate-urls-update-last-seen', [AdminSeoWorkDuplicateURLCtrl::class, 'viewDuplicateUrlUpdateLastSeen']);


    //Admin - Attendance
    Route::get('admin/attendance/single-user', [AdminAttendanceCtrl::class, 'viewSingleUser'])->name('admin.attendance.single');
    Route::post('ajax/admin/attendance/single-user', [AdminAttendanceCtrl::class, 'fetchSingleUser']);


    //Admin - notifications
    Route::get('admin/notification/create', [AdminNotificationCtrl::class, 'viewCreate'])->name('admin.notification.create');
    Route::post('ajax/admin/notification/create', [AdminNotificationCtrl::class, 'createNotification']);

    Route::get('admin/notification/list', [AdminNotificationCtrl::class, 'viewList'])->name('admin.notification.list');
    // Route::get('ajax/admin/notification/user-list', [AdminNotificationCtrl::class, 'userList']);


    Route::get('ajax/admin/notification/list', [AdminNotificationCtrl::class, 'notificationList']);
    Route::post('ajax/admin/notification/list/emp-names', [AdminNotificationCtrl::class, 'usersDetails']);

    //update notification
    Route::post('ajax/admin/notification/update', [AdminNotificationCtrl::class, 'updateNotification']);
    //delete notification
    Route::post('ajax/admin/notification/delete', [AdminNotificationCtrl::class, 'deleteNotification']);


    //Admin - Manage Users
    Route::get('admin/user/add-new', [AdminUserCtrl::class, 'viewAddUser'])->name('admin.users.add');
    Route::post('ajax/admin/user/add-new', [EmpUserCtrl::class, 'addNewUser']);

    Route::get('admin/user/manage', [AdminUserCtrl::class, 'viewManageUser'])->name('admin.users.list');
    Route::get('ajax/admin/user/all-list', [EmpUserCtrl::class, 'usersList']);
    Route::post('ajax/admin/user/update-status', [EmpUserCtrl::class, 'updateUserStatus']);

    Route::get('admin/user/manage/edit/{user_id}', [AdminUserCtrl::class, 'viewEditUser'])->whereNumber('user_id')->name('admin.users.edit');
    Route::post('ajax/admin/user/manage/edit', [EmpUserCtrl::class, 'updateUser']);

    Route::get('admin/user/manage/edit/{user_id}/user-info', [AdminUserInfoCtrl::class, 'viewEditUserInfo'])->whereNumber('user_id')->name('admin.users.edit_user_info');
    Route::post('ajax/admin/user/manage/edit/user-info-insert', [AdminUserInfoCtrl::class, 'insertUserInfo']);
    Route::post('ajax/admin/user/manage/edit/user-info-update', [AdminUserInfoCtrl::class, 'updateUserInfo']);
    Route::get('admin/user/manage/detailed-user-view', [AdminUserInfoCtrl::class, 'getDetailedView']);
    Route::get('ajax/admin/user/manage/detailed-user-info', [AdminUserInfoCtrl::class, 'getDetailedInfo']);


    //Website Management
    Route::get('admin/website/manage/relation-with-user', [SiteUserRelationCtrl::class, 'viewForSiteUserRelation'])->name('admin.site_manage.user_relation');
    Route::post('ajax/admin/website/manage/relation-with-user', [SiteUserRelationCtrl::class, 'assignSiteUserRelation']);
    Route::get('ajax/admin/website/manage/relation-with-user/fetch', [SiteUserRelationCtrl::class, 'fetchSiteUserRelation']);
    Route::post('ajax/admin/website/manage/relation-with-user/delete', [SiteUserRelationCtrl::class, 'deleteSiteUserRelation']);

    Route::get('admin/website/manage/edit-relation-with-user/{userId}', [SiteUserRelationCtrl::class, 'viewForEditSiteUserRelation'])
      ->whereNumber('userId')->name('admin.site_manage.user_relation_edit');
    Route::get('ajax/admin/website/manage/edit-relation-with-user/{userId}/fetch', [SiteUserRelationCtrl::class, 'fetchSingleUserSiteRelation'])
      ->whereNumber('userId');

    /**
     * Manage Website Information
     */
    Route::get('admin/manage/site-info/list', [WebsiteCtrl::class, 'addSiteForm'])->name('admin.manage.site_info');
    Route::get('ajax/admin/site-info/list', [WebsiteCtrl::class, 'fetchSiteList']);
    Route::post('ajax/admin/site-info/add', [WebsiteCtrl::class, 'addNewSite']);
    Route::post('ajax/admin/site-info/edit', [WebsiteCtrl::class, 'getSingleSiteId']);
    Route::post('ajax/admin/site-info/update', [WebsiteCtrl::class, 'updateSite']);
    Route::post('ajax/admin/site-info/delete', [WebsiteCtrl::class, 'deleteSite']);


    //SEO team management
    Route::get('admin/seo-team/manage/create', [AdminSeoTeamCtrl::class, 'viewCreateTeam'])->name('admin.seo_team.create');
    Route::get('admin/seo-team/manage/edit-info/{team_id}', [AdminSeoTeamCtrl::class, 'viewEditTeam'])->whereNumber('team_id')->name('admin.seo_team.edit');
    Route::get('ajax/admin/seo-team/manage/member-list/{team_id}', [AdminSeoTeamCtrl::class, 'listMemberTeam'])->whereNumber('team_id');
    Route::get('ajax/admin/seo-team/manage/list', [AdminSeoTeamCtrl::class, 'listTeam']);

    Route::post('ajax/admin/seo-team/manage/create', [AdminSeoTeamCtrl::class, 'createTeam']);
    Route::post('ajax/admin/seo-team/manage/update', [AdminSeoTeamCtrl::class, 'updateTeam']);

    Route::post('ajax/admin/seo-team/manage/delete', [AdminSeoTeamCtrl::class, 'deleteTeam']);
    Route::post('ajax/admin/seo-team/manage/member-delete', [AdminSeoTeamCtrl::class, 'deleteMember']);

    Route::get('admin/seo/team-info', [AdminSeoTeamCtrl::class, 'viewSeoTeam'])->name('admin.seo_team.team_info');



    //Admin - Profile Manage
    Route::get('admin/profile/view', [ProfileCtrl::class, 'viewAdminProfile'])->name('admin.profile.view');
    Route::get('admin/profile/change-password', [ProfileCtrl::class, 'viewAdminChangePassword'])->name('admin.profile.password');
    Route::post('ajax/admin/profile/change-password', [ProfileManagerCtrl::class, 'changePasswordAdmin']);


    //login as user
    Route::get('admin/login-as-user/{userId}/login', [LoginAsUserCtrl::class, 'login'])->whereNumber('userId');


    //Admin: order dashboard
    Route::get('admin/order/dashboard', [AdminOrderDashboardCtrl::class, 'dashboard'])->name('admin.order.dashboard');

    Route::post('ajax/admin/order/dashboard/get/year-sales', [OrderStatsCtrl::class, 'fetchYearSales']);

    Route::post('ajax/admin/order/dashboard/get/month-sales', [OrderStatsCtrl::class, 'fetchMonthSales']);

    Route::post('ajax/admin/order/dashboard/get/user-year-sales', [OrderStatsCtrl::class, 'fetchYearSalesUser']);

    Route::post('ajax/admin/order/dashboard/get/user-month-sales', [OrderStatsCtrl::class, 'fetchMonthSalesUser']);

    Route::post('ajax/admin/order/dashboard/get/crr-month-total-sale', [OrderStatsCtrl::class, 'fetchCrrMonthTotalSale']);

    Route::get('admin/order/dashboard/seo-sales-team', [AdminOrderDashboardCtrl::class, 'dashboardBySalesTeam'])->name('admin.order.dashboard.seo_sales_team');

    Route::post('ajax/admin/order/dashboard/seo-sales-team', [OrderStatsCtrl::class, 'fetchMonthOrderBySalesTeam']);




    //order management add
    Route::get('admin/order/manage/add', [AdminOrderManageCtrl::class, 'viewAddOrderRecord'])->name('admin.order.add');
    Route::get('admin/order/manage/edit/{ordId}', [AdminOrderManageCtrl::class, 'editOrderRecord'])->name('admin.order.update');

    Route::get('ajax/admin/order/manage/fetch', [AdminOrderManageCtrl::class, 'fetchOrderRecord']);
    Route::post('ajax/admin/order/manage/add', [AdminOrderManageCtrl::class, 'addOrderRecord']);
    Route::post('ajax/admin/order/manage/update', [AdminOrderManageCtrl::class, 'updateOrderRecord']);
    Route::post('ajax/admin/order/manage/delete', [AdminOrderManageCtrl::class, 'deleteOrderRecord']);




    //order management Month wise
    Route::get('admin/order/report/month-view', [AdminOrderReportMonthCtrl::class, 'viewMonthReport'])->name('admin.order.month_report');
    Route::post('ajax/admin/order/report/month-view', [AdminOrderReportMonthCtrl::class, 'fecthMonthReport']);
    Route::post('ajax/admin/order/report/month-view/details', [AdminOrderReportMonthCtrl::class, 'fecthMonthReportDetails']);
    Route::post('ajax/admin/order/report/month-view/details-users', [AdminOrderReportMonthCtrl::class, 'fecthMonthReportUsersDetails']);
    Route::post('ajax/admin/order/report/month-view/details-sites', [AdminOrderReportMonthCtrl::class, 'fecthMonthReportSitesDetails']);
    Route::post('ajax/admin/order/report/month-view/details-date', [AdminOrderReportMonthCtrl::class, 'fecthMonthReportDateDetails']);
    Route::post('ajax/admin/order/report/month-view/details-sites-users', [AdminOrderReportMonthCtrl::class, 'fecthMonthReportUsersSiteDetails']);

    //order management Day wise
    Route::get('admin/order/report/day-view', [AdminOrderReportDayCtrl::class, 'viewDayReport'])->name('admin.order.day_report');
    Route::post('ajax/admin/order/report/day-view', [AdminOrderReportDayCtrl::class, 'fecthDayReport']);
    Route::post('ajax/admin/order/report/day-view/details', [AdminOrderReportDayCtrl::class, 'fecthDayReportDetails']);
    Route::post('ajax/admin/order/report/day-view/details-users', [AdminOrderReportDayCtrl::class, 'fecthDayReportUsersDetails']);
    Route::post('ajax/admin/order/report/day-view/details-sites', [AdminOrderReportDayCtrl::class, 'fecthDayReportSitesDetails']);
    Route::post('ajax/admin/order/report/day-view/details-sites-users', [AdminOrderReportDayCtrl::class, 'fecthDayReportUsersSiteDetails']);



    //checklist

    Route::get('admin/checklist/rule/create', [ChecklistCtrl::class, 'viewFormChecklist'])->name('admin.checklist.create_rule');
    Route::post('ajax/admin/checklist/rule/create', [ChecklistCtrl::class, 'saveChecklistInfo']);
    Route::get('ajax/admin/checklist/rule/fetch-list', [ChecklistCtrl::class, 'fetchChecklistInfo']);
    Route::post('ajax/admin/checklist/rule/delete', [ChecklistCtrl::class, 'deleteChecklistInfo']);
    Route::get('admin/checklist/rule/{checklist_id}/edit', [ChecklistCtrl::class, 'viewFormEditChecklist'])
      ->whereNumber('checklist_id')->name('admin.checklist.edit_rule');
    Route::post('ajax/admin/checklist/rule/save/edit', [ChecklistCtrl::class, 'saveEditChecklist']);



    Route::get('admin/checklist/users-group/add', [AdminChecklistGroupCtrl::class, 'viewCreateGroup'])->name('admin.checklist.create');
    Route::post('ajax/admin/checklist/users-group/add', [AdminChecklistGroupCtrl::class, 'createGroup']);
    Route::get('ajax/admin/checklist/users-group/fetch', [AdminChecklistGroupCtrl::class, 'fetchCreateGroup']);
    Route::post('ajax/admin/checklist/users-group/delete', [AdminChecklistGroupCtrl::class, 'deleteCreateGroup']);
    Route::get('admin/checklist/users-group/{group_id}/edit', [AdminChecklistGroupCtrl::class, 'viewEditGroup'])
      ->whereNumber('group_id')->name('admin.checklist.edit');
    Route::post('ajax/admin/checklist/users-group/edit/save', [AdminChecklistGroupCtrl::class, 'saveEditGroup']);

    Route::get('ajax/admin/checklist/users-group/fetch/{group_id}/users', [AdminChecklistGroupCtrl::class, 'fetchGroupUsers'])->whereNumber('group_id');
    Route::post('ajax/admin/checklist/users-group/users/delete', [AdminChecklistGroupCtrl::class, 'deleteGroupUsers']);


    //Admin - Request New Content
    Route::get('admin/request/content/new', [AdminRequestNewContentCtrl::class, 'viewReqNewContent'])->name('admin.content.new');
    Route::post('ajax/admin/request/content/new', [AdminRequestNewContentCtrl::class, 'saveReqNewContent']);


    Route::get('admin/request/content/list', [AdminWriterTeamLeader::class, 'viewAssignContent'])->name('admin.content.list');
    Route::get('ajax/admin/request/content/list', [AdminWriterTeamLeader::class, 'fetchRequestedContentList']);
    Route::post('ajax/admin/request/content/list/delete', [AdminWriterTeamLeader::class, 'deleteRequestedContent']);
    Route::post('ajax/admin/request/content/list/approve', [AdminWriterTeamLeader::class, 'approveContent']);

    //content assigned to writer by - team leader
    Route::get('admin/request/content/{contentId}/assign', [AdminWriterTeamLeader::class, 'viewEditAssignContent'])->name('admin.content.assign');
    Route::post('ajax/admin/request/content/assign/save', [AdminWriterTeamLeader::class, 'assignContentToWriter']);
    Route::post('ajax/admin/request/content/list/get-remarks', [AdminWriterTeamLeader::class, 'fetchContentRemarks']);

    //request content preview for - Team Leader
    Route::get('admin/request/content/{pId}/preview', [AdminWriterTeamLeader::class, 'viewContentPreview'])->whereNumber('pId')->name('cw.content.preview');;
    Route::post('ajax/admin/request/content/preview', [AdminWriterTeamLeader::class, 'getContentPreview']);
    Route::post('ajax/admin/request/content/preview/submit-remark', [AdminWriterTeamLeader::class, 'submitRemark']);


    /**
     * Admin Assign Task
     */

    Route::get('admin/manage/users/assign-task/user', [AssignTaskCtrl::class, 'getAssignForm'])->name('admin.manage.users.assign_task.user');
    Route::post('admin/manage/users/assign-task/add', [AssignTaskCtrl::class, 'addAssignForm']);
    Route::get('ajax/admin/manage/users/assign-task/fetch', [AssignTaskCtrl::class, 'fetchAssignForm']);
    Route::get('admin/manage/users/assign-task/{user_id}/images/{id}', [AssignTaskCtrl::class, 'getAssignImages']);
    Route::get('admin/manage/users/assign-task/{folder}/{img_id}', [AssignTaskCtrl::class, 'renderTaskAssignImage']);
    Route::get('admin/manage/users/assign-task/edit/{id}', [AssignTaskCtrl::class, 'editAssignTask']);
    Route::get('admin/manage/users/assign-task/get-assign-badges', [AssignTaskCtrl::class, 'badgesAssignTask']);


    /**
     * Admin Feedback 
     */
    Route::get('admin/manage/users/feedback/view', [FeedbackCtrl::class, 'viewFeedBack'])->name('admin.manage.user.feedback.view');
    Route::get('admin/manage/users/feedback/fetch-feedback', [FeedbackCtrl::class, 'fetchFeedBack']);
    Route::get('admin/manage/users/feedback/fetch-modal-data', [FeedbackCtrl::class, 'fetchModalData']);
    Route::post('admin/manage/users/feedback/add-reply', [FeedbackCtrl::class, 'addReplyFeedback']);
    Route::post('admin/manage/users/feedback/add-status', [FeedbackCtrl::class, 'addStatusFeedback']);
    Route::get('admin/manage/users/feedback/images/{id}', [FeedbackCtrl::class, 'getFeedImages']);
    Route::get('admin/manage/users/feedback/{folder}/{img_id}', [FeedbackCtrl::class, 'feedBackImage']);
    Route::get('admin/manage/users/feedback/feed-badges', [FeedbackCtrl::class, 'badgesFeedback']);


    /**
     * Manage UserInfo Documents
     */


    Route::get('admin/manage/document/user/approve-status', [UsersApproveStatusDocCtrl::class, 'viewApproveStatusDoc']);
    Route::get('ajax/admin/manage/document/user/get-data', [UsersApproveStatusDocCtrl::class, 'fetchUsersDocTemp']);
    Route::post('ajax/admin/manage/document/user/approve', [UsersApproveStatusDocCtrl::class, 'approveUsersDoc']);
    Route::post('ajax/admin/manage/document/user/approve-bank', [UsersApproveStatusDocCtrl::class, 'approveUsersBankDoc']);
    Route::post('ajax/admin/manage/document/user/approve-address', [UsersApproveStatusDocCtrl::class, 'approveAddress']);
    Route::post('ajax/admin/manage/document/user/update', [UsersApproveStatusDocCtrl::class, 'updateUsersRemark']);
    Route::post('ajax/admin/manage/document/user/update-address', [UsersApproveStatusDocCtrl::class, 'updateAddressRemark']);
    Route::post('ajax/admin/manage/document/user/fetch-remark', [UsersApproveStatusDocCtrl::class, 'fetchUsersRemark']);
    Route::post('ajax/admin/manage/document/user/fetch-bank-remark', [UsersApproveStatusDocCtrl::class, 'fetchUsersBankInfoRemark']);
    Route::post('ajax/admin/manage/document/user/fetch-address-remark', [UsersApproveStatusDocCtrl::class, 'fetchUsersAddressRemark']);

    /**
     * Manage User Bank Info
     */
    Route::get('admin/user/manage/edit/{userId}/bank-info', [UserBankInfoCtrl::class, 'fetchBankInfoIdAData']);
    Route::post('admin/manage/options/bank-info/add-new-bank-info', [UserBankInfoCtrl::class, 'addNewBankInfo']);
    Route::post('admin/manage/options/bank-info/add-new-bank-info-update', [UserBankInfoCtrl::class, 'addNewBankInfoupdate']);


    /**
     * Get for Admin Document Bages
     */
    Route::get('admin/manage/document/user/get-bages', [UsersApproveStatusDocCtrl::class, 'getbagesDocument']);


    /**
     * Manage Employee Departments
     */
    Route::get('admin/department/list', [DepartmentCtrl::class, 'addDepartment'])->name('admin.department.list');
    Route::get('ajax/admin/department/list', [DepartmentCtrl::class, 'fetchDepartmentList']);
    Route::post('ajax/admin/department/add', [DepartmentCtrl::class, 'addNewDepartment']);
    Route::post('ajax/admin/department/edit', [DepartmentCtrl::class, 'getSingleId']);
    Route::post('ajax/admin/department/update', [DepartmentCtrl::class, 'updateDepartment']);
    Route::post('ajax/admin/department/delete', [DepartmentCtrl::class, 'deleteDepartment']);


    /**
     * Manage Designations*
     */
    Route::get('admin/designation/list', [DesignationCtrl::class, 'addDesignation'])->name('admin.designation.list');
    Route::get('ajax/admin/designation/list', [DesignationCtrl::class, 'fetchDesignationList']);
    Route::post('ajax/admin/designation/add', [DesignationCtrl::class, 'addNewDesignation']);
    Route::post('ajax/admin/designation/edit', [DesignationCtrl::class, 'getSingledesigId']);
    Route::post('ajax/admin/designation/update', [DesignationCtrl::class, 'updateDesignation']);
    Route::post('ajax/admin/designation/delete', [DesignationCtrl::class, 'deleteDesignation']);


    /**
     * Manage Posts
     */
    Route::get('admin/post/list', [PostCtrl::class, 'addPost'])->name('admin.post.list');
    Route::get('ajax/admin/post/list', [PostCtrl::class, 'fetchPostList']);
    Route::post('ajax/admin/post/add', [PostCtrl::class, 'addNewPost']);
    Route::post('ajax/admin/post/edit', [PostCtrl::class, 'getSinglePostId']);
    Route::post('ajax/admin/post/update', [PostCtrl::class, 'updatePost']);
    Route::post('ajax/admin/post/delete', [PostCtrl::class, 'deletePost']);




    /**
     * Manage Notification Options
     */

    Route::get('admin/notification/manage/options/notification/add', [ManageOptionsCtrl::class, 'fetchIdAData']);
    Route::post('admin/manage/options/notification/add-new-message', [ManageOptionsCtrl::class, 'addNewMessage']);


    /**
     * Manage Min Work Time In a Day
     */
    Route::get('admin/manage/options/work-time/add', [ManageOptionsCtrl::class, 'fetchWorkTimeIdAData']);
    Route::post('admin/manage/options/work-time/add-new-work-time', [ManageOptionsCtrl::class, 'addNewWorkTime']);



    /**
     * Manage User Address
     */
    Route::get('admin/manage/address/user/edit/{userId}/user-address', [UserAddressCtrl::class, 'fetchUserAddressIdData']);
    Route::post('admin/manage/address/user/add-new-address', [UserAddressCtrl::class, 'addNewAddress']);
    Route::post('admin/manage/address/user/update', [UserAddressCtrl::class, 'addNewAddressupdate']);


    /**
     * Manage User Salary
     */
    Route::get('admin/manage/salary/user/edit/{userId}/user-salary', [SalaryCtrl::class, 'fetchUserSalaryIdData']);
    Route::get('ajax/admin/manage/salary/list/{userId}', [SalaryCtrl::class, 'fetchAllSalary']);
    Route::post('ajax/admin/manage/salary/add-new', [SalaryCtrl::class, 'addNewSalary']);
    Route::post('ajax/admin/manage/salary/update', [SalaryCtrl::class, 'updateSalary']);
    Route::post('ajax/admin/manage/salary/delete', [SalaryCtrl::class, 'deleteSalary']);


    /**
     * Manage Seo tasks
     */
    Route::get('admin/manage/seo-task-list/add', [SEOTaskCtrl::class, 'addSeoForm']);
    Route::post('ajax/admin/manage/seo-task-list/add-new-task', [SEOTaskCtrl::class, 'addNewTask']);
    Route::get('ajax/admin/manage/seo-task-list/list', [SEOTaskCtrl::class, 'fetchTaskList']);
    Route::post('ajax/admin/manage/seo-task-list/update', [SEOTaskCtrl::class, 'updateTask']);
    Route::post('ajax/admin/manage/seo-task-list/delete', [SEOTaskCtrl::class, 'deleteTask']);

    // manage alarm
    Route::get('admin/manage/users/alarm/create', [UserAlarmCtrl::class, 'create']);
    Route::post('admin/manage/users/alarm/add-alarm', [UserAlarmCtrl::class, 'addAlarmNew']);
    Route::get('ajax/admin/manage/users/alarm/fetch-data', [UserAlarmCtrl::class, 'fetchAllAlarm']);
    Route::post('admin/manage/users/alarm/active-status', [UserAlarmCtrl::class, 'addStatusActive']);
    Route::post('admin/manage/users/alarm/not-active-status', [UserAlarmCtrl::class, 'addStatusNotActive']);
    Route::post('ajax/admin/manage/users/alarm/delete-alarm', [UserAlarmCtrl::class, 'alarmDelete']);
    Route::post('ajax/admin/manage/users/alarm/update', [UserAlarmCtrl::class, 'alarmUpdate']);
    Route::get('admin/manage/users/alarm/get-details', [UserAlarmCtrl::class, 'getDetails']);
    Route::post('ajax/admin/manage/users/alarm/add-alarm', [UserAlarmCtrl::class, 'getAlarmDetails']);


    //manage Login Location
    Route::get('admin/login-location/view', [LoginLocationCtrl::class, 'viewLoginLocation']);

     /**
     * Work Report CW
     */
    Route::get('admin/work-report-cw/view', [WorkReportCWCtrl::class, 'viewReport']);
    Route::post('ajax/work-report-cw/get-word-count', [WorkReportCWCtrl::class, 'fetchMonthCount']);
    Route::post('ajax/work-report-cw/fetch-data', [WorkReportCWCtrl::class, 'fetchData']);

    /**
     * Company Policies
     */
    Route::get('admin/company-policies/view',[CompanyPoliciesCtrl::class,'viewCompanyPolicy']);
    Route::get('admin/company-policies/{folder}/{img_id}', [CompanyPoliciesCtrl::class, 'renderCompanyImage']);
    
    

    // Clear cache in laravel
    // Route::get('admin/cmd/clear-cache', function () {
    //   return  Artisan::call('cache:clear');
    // });
    // Route::get('admin/cmd/route-clear', function () {
    //   return  Artisan::call('route:clear');
    // });
    // Route::get('admin/cmd/view-clear', function () {
    //   return  Artisan::call('view:clear');
    // });
    // Route::get('admin/cmd/config-clear', function () {
    //   return  Artisan::call('config:clear');
    // });


    //mail test route
    // Route::get('admin/test-mail', function () {

    //   $details = [
    //     'subject' => 'Registration Successful at Work Report Portal - Logelite',
    //     'username' => 'dev_test',
    //     'password' => 'test'
    //   ];

    //   try {
    //     Mail::to('developer@logelite.com')->send(new UserAdded($details));

    //     $return['code'] = 200;
    //     $return['msg'] = 'New employee has been added.';
    //   } catch (Exception $e) {

    //     $return['code'] = 200;
    //     $return['msg'] = 'New employee has been added. But mail not send to the user.';
    //     $return['err'] = $e->getMessage();
    //   }

    //   return response()->json($return);
    // });
  });



  /**
   * Users Assign Task
   */

  Route::get('users/assign-task/view', [UsersAssignTaskCtrl::class, 'viewUserTask'])->name('users.assign_task.view');
  Route::get('users/assign-task/fetch', [UsersAssignTaskCtrl::class, 'fetchUserTask']);
  Route::get('users/assign-task/user/images/{id}', [UsersAssignTaskCtrl::class, 'getUserAssignImages']);
  Route::get('users/assign-task/{folder}/{img_id}', [UsersAssignTaskCtrl::class, 'renderUserTaskAssignImage']);
  Route::post('users/assign-task/user/status-progress', [UsersAssignTaskCtrl::class, 'statusInProgress']);
  Route::post('users/assign-task/user/submit-remark', [UsersAssignTaskCtrl::class, 'submitRemark']);
  Route::post('ajax/users/assign-task/user/assign-notify', [UsersAssignTaskCtrl::class, 'assignNotify']);
  Route::get('ajax/users/assign-task/user/get-badges', [UsersAssignTaskCtrl::class, 'assignBadges']);



  //Department
  Route::get('ajax/department/all-list', [EmpDepartmentCtrl::class, 'allList']);
  Route::get('ajax/designation/all-list', [EmpDesignationCtrl::class, 'allList']);
  Route::get('ajax/post/all-list', [EmpPostCtrl::class, 'allList']);

  /**
   * Users Feedback/Complain
   */
  Route::get('users/feedback/view', [UsersFeedbackCtrl::class, 'viewFeedbackForm'])->name('users.feedback.*');
  Route::post('users/feedback/add-form', [UsersFeedbackCtrl::class, 'addFeedbackForm']);
  Route::get('users/feedback/fetch-data', [UsersFeedbackCtrl::class, 'fetchFeedbackData']);
  Route::post('users/feedback/add-reply', [UsersFeedbackCtrl::class, 'addReplyFeedback']);
  Route::get('users/feedback/fetch-action-modal-data', [UsersFeedbackCtrl::class, 'fetchModalData']);
  Route::get('users/feedback/{id}', [UsersFeedbackCtrl::class, 'getFeedbackImages']);
  Route::get('users/feedback/{folder}/{img_id}', [UsersFeedbackCtrl::class, 'renderFeedBackImage']);

  /**
   * Office Expenses
   */
  Route::get('admin/manage/office-expenses/add-form', [OfficeExpensesCtrl::class, 'viewForm'])->name('admin.office_expenses');
  Route::post('ajax/admin/manage/office-expenses/add-form-data', [OfficeExpensesCtrl::class, 'addForm']);
  Route::get('admin/manage/office-expenses/view', [OfficeExpensesCtrl::class, 'viewOfficeExpenses'])->name('admin.office_expenses');
  Route::post('ajax/admin/manage/office-expenses/fetch-expenses', [OfficeExpensesCtrl::class, 'fetchOfficeExpenses']);


  /**
   * Employee Documentation
   */
  Route::get('users/employee-documents', [UsersDocumentCtrl::class, 'addDocForm'])->name('users.upload-document.*');
  Route::post('users/employee-documents/add', [UsersDocumentCtrl::class, 'addDocSubmit']);
  //  Route::get('users/employee-documents/view', [UsersDocumentCtrl::class, 'viewForUpdateDoc']);
  Route::get('users/employee-documents/getdata', [UsersDocumentCtrl::class, 'fetchDoc']);
  Route::get('users/employee-documents/images/{folder}/{img_id}', [UsersDocumentCtrl::class, 'renderDocumentImage']);
  Route::post('users/employee-documents/temp-insert', [UsersDocumentCtrl::class, 'insertDocTempImage']);
  Route::post('users/employee-documents/bank-info-temp-insert', [UsersDocumentCtrl::class, 'insertBankInfoTemp']);
  Route::get('profile/image/{folder}/{img_id}', [UsersDocumentCtrl::class, 'renderDocumentImage']);
  Route::post('users/employee-documents/update-address-local', [UsersDocumentCtrl::class, 'insertUserAddressLocalTemp']);
  Route::post('users/employee-documents/local-update', [UsersDocumentCtrl::class, 'updateTempDataLocal']);
  Route::post('users/employee-documents/permanent-update', [UsersDocumentCtrl::class, 'updateTempDataPerm']);
  Route::post('users/employee-documents/update-address-permanent', [UsersDocumentCtrl::class, 'insertUserAddressPermanentTemp']);
  Route::post('users/employee-documents/update-address-deny', [UsersDocumentCtrl::class, 'denyUserAddressTemp']);
  Route::post('users/employee-documents/add-vaccine-one', [UsersDocumentCtrl::class, 'addVaccineFormDoseOne']);
  Route::post('users/employee-documents/add-vaccine-two', [UsersDocumentCtrl::class, 'addVaccineFormDoseTwo']);

  /**
   * Users Alarm Alert
   */
  Route::get('users/alarm/fetch-alarm', [AlarmCtrl::class, 'getAlarm']);
  Route::get('users/alarm/end-task', [AlarmCtrl::class, 'endAlarm']);
  Route::get('users/alarm/get-audio/alarm_tone.mp3', [AlarmCtrl::class, 'getAudio']);

  /**
   * Get Login Location
   */

  Route::get('ajax/users/login-location/fetch-data', [UserLoginLocationCtrl::class, 'getLocate']);


  /**
   * Get Users Policy
   */
  Route::get('manage/user-policies/view',[UsersPolicyCtrl::class,'viewPolicy']);
  Route::get('manage/user-policies/{folder}/{img_id}', [UsersPolicyCtrl::class, 'renderDocumentImage']);
});



















//test
// Route::view('view','admin.emails.user_added');
// Route::get('get', function () {
//   return date("Y-m-d h:m:s A") . " - " . date_default_timezone_get();
// });
