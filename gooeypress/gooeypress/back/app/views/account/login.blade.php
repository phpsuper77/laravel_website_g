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
<link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" media="screen"/>
<link href="{{ asset('assets/plugins/boostrapv3/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/plugins/boostrapv3/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- END CORE CSS FRAMEWORK -->
<!-- BEGIN CSS TEMPLATE -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/custom-icon-set.css') }}" rel="stylesheet" type="text/css"/>
<!-- END CSS TEMPLATE -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="error-body no-top">
<div class="container">
  <div class="row login-container column-seperation">  
        <div class="col-md-6 col-md-offset-3"> <br>
		 <form id="login-form" class="login-form" action="{{ url('account/login') }}" method="post">
		 <div class="row">
		 <div class="form-group col-md-10">
            <label class="form-label">Username</label>
            <div class="controls">
				<div class="input-with-icon  right">                                       
					<i class=""></i>
					<input type="text" name="username" id="txtusername" class="form-control">                                 
				</div>
            </div>
          </div>
          </div>
		  <div class="row">
          <div class="form-group col-md-10">
            <label class="form-label">Password</label>
            <span class="help"></span>
            <div class="controls">
				<div class="input-with-icon  right">                                       
					<i class=""></i>
					<input type="password" name="password" id="txtpassword" class="form-control">                                 
				</div>
            </div>
          </div>
          </div>
		  <!--<div class="row">
          <div class="control-group  col-md-10">
            <div class="checkbox checkbox check-success"> <a href="#">Trouble login in?</a>&nbsp;&nbsp;
              <input type="checkbox" id="checkbox1" value="1">
              <label for="checkbox1">Keep me reminded </label>
            </div>
          </div>
          </div>-->
          <div class="row">
            <div class="col-md-10">
              <button class="btn btn-primary btn-cons pull-right" type="submit">Login</button>
            </div>
          </div>
		  </form>
        </div>
     
    
  </div>
</div>
<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<script src="{{ asset('assets/plugins/jquery-1.8.3.min.js' )}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js' )}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/pace/pace.min.js' )}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-validation/js/jquery.validate.min.js' )}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/login.js' )}}" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS -->
<!-- END CORE TEMPLATE JS -->
</body>
</html>
