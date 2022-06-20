<input type="hidden" id="base_url" value="{{url('')}}">
<input type="hidden" id="fetch-new-noti" value="{{url('')}}/ajax/fetch-new-notification">
<input type="hidden" id="fetch-view-noti" value="{{url('')}}/notifications">
<input type="hidden" id="fetch-noti-logo" value="{{url('')}}/layout/dist/img/logo.png">
<input type="hidden" id="fetch-noti-board-msg" value="{{url('')}}/ajax/notice-board-msg">
<input type="hidden" id="update-lat-lon" value="{{url('')}}/ajax/update/lat-lon-location">
<input type="hidden" id="csrf_token_ajax" value="{{csrf_token()}}">

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
  <img class="animation__shake" src="{{url('')}}/layout/dist/img/logo.png" alt="Logo" height="55" width="204">
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <li class="nav-item h5 text-danger" id="notice-board"></li>

    <li class="nav-item">
      <a class="nav-link text-danger logout-link" href="{{url('')}}/logout" role="button">
        <i class="fas fa-door-open"></i>
      </a>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown" id="notification-dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-danger navbar-badge d-none">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header"><span></span></span>
        <div class="dropdown-divider"></div>
        <a href="{{url('')}}/notifications" class="dropdown-item new-noti-a d-none">
          <i class="fas fa-envelope mr-2"></i> <span class="new-noti-span"></span>
          <span class="float-right text-muted text-sm last-noti-date"></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{url('')}}/notifications" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

  </ul>
</nav>
<!-- /.navbar -->