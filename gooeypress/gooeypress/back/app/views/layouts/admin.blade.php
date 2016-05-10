<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>Webarch - Responsive Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="" name="description" />
<meta content="" name="author" />

<!-- BEGIN CORE CSS FRAMEWORK -->
<link href="{{ asset('assets/plugins/boostrapv3/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/plugins/boostrapv3/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/animate.min.css" rel="stylesheet') }}" type="text/css"/>
<!-- END CORE CSS FRAMEWORK -->

<!-- BEGIN CSS TEMPLATE -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/custom-icon-set.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/magic_space.css') }}" rel="stylesheet" type="text/css"/>
<!-- END CSS TEMPLATE -->

<!-- BEGIN CORE JS FRAMEWORK-->
    
<!--[if lt IE 9]>
<script src="assets/plugins/respond.js"></script>
<![endif]-->

<script src="{{ asset('assets/plugins/jquery-1.8.3.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/breakpoints.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-unveil/jquery.unveil.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-block-ui/jqueryblockui.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-lazyload/jquery.lazyload.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery.cookie.js') }}" type="text/javascript"></script>
<!-- END CORE JS FRAMEWORK -->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="assets/js/core.js" type="text/javascript"></script>
<script src="assets/js/demo.js" type="text/javascript"></script>

<!-- END CORE TEMPLATE JS -->

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse ">
  <!-- BEGIN TOP NAVIGATION BAR -->
  <div class="navbar-inner">
    <div class="header-seperation">
      <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">
        <li class="dropdown"> <a id="main-menu-toggle" href="#main-menu"  class="" >
          <div class="iconset top-menu-toggle-white"></div>
          </a> </li>
      </ul>
      <!-- BEGIN LOGO -->
      <a href="index.html"><img src="{{ asset('assets/img/logo.png') }}" class="logo" alt=""  data-src="assets/img/logo.png" data-src-retina="assets/img/logo2x.png" width="106" height="21"/></a>
      <!-- END LOGO -->
    </div>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <div class="header-quick-nav" >
<a href="{{ url('account/logout') }}">Logout</a>
    </div>
    <!-- END TOP NAVIGATION MENU -->
  </div>
  <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
  <!-- BEGIN SIDEBAR -->
  <div class="page-sidebar" id="main-menu">
    <div class="page-sidebar-wrapper" id="main-menu-wrapper">
      <!-- BEGIN SIDEBAR MENU -->
      <ul>
        <li class="start active open"> <a href="{{ url('adm/theme/list') }}"> <i class="fa fa-th"></i> <span class="title">Themes</span>
 <span class="selected"></span> <span class="arrow open"></span> </a>
    <ul class="sub-menu">
        <li><a href="{{ url('adm/theme/list') }}">List</a></li>
        <li><a href="{{ url('adm/theme/new') }}">Add New</a></li>
        <li><a>Completed: {{ Theme::completed() }}/{{ Theme::all()->count() }}</a></li>
    </ul>
</li>
      </ul>
      <div class="clearfix"></div>
      <!-- END SIDEBAR MENU -->
    </div>
  </div>
  <!-- END SIDEBAR -->
  <!-- BEGIN PAGE CONTAINER-->

<div class="page-content">
    <div class="content">
            @yield('content')
    </div>
</div>
		  
    </div>
 
<!-- END CONTAINER -->
<!-- END CONTAINER -->
</body>
</html>
