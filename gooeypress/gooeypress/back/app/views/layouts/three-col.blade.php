<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie ie7 ltie8 ltie9" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 ltie9" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Browse Themes - Gooeypress</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="HandheldFriendly" content="true" />
	<meta name="MobileOptimized" content="320" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="{{ asset('front/css/site/all.css?v=140818111217') }}" rel="stylesheet" type="text/css" media="all" />
	<!--[if lt IE 9 ]>
		<link href="{{ asset('front/css/site/ltie9.css?v=140818111217') }}" rel="stylesheet" type="text/css" media="all"  />
		<link href="{{ asset('front/css/PIE.htc') }}" rel="stylesheet" type="text/css" />
	<![endif]-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700" type="text/css" rel="stylesheet" />
	<script>
		(function() {
			if ('-ms-user-select' in document.documentElement.style && navigator.userAgent.match(/IEMobile\/10\.0/)) {
				var msViewportStyle = document.createElement('style');
				msViewportStyle.appendChild(document.createTextNode('@-ms-viewport{width:auto!important}'));
				document.getElementsByTagName('head')[0].appendChild(msViewportStyle);
			}
			
			window.suzi = {
				jsRootPath: '{{ asset('front/js/') }}',
				jsDistPath: '{{ asset('front/js/build/') }}'
			};
		})();
	</script>
	<script src="{{ asset('front/js/build/base.js?v=140712105904') }}"></script>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>

<div class="header" id="js_header" role="banner">
	<div class="std_width pos_relative">
		<h3 class="hidden"><a href="/themes">Gooeypress</a></h3>
		<p id="logo" class="reset"><a href="/themes"><img src="{{ asset('front/images/site/logo.svg') }}" width="170" height="30" alt="Gooeypress" onerror="this.src='/images/site/logo.png'" /></a></p>

		<a href="#js_main_actions" class="icon_link icon_link_menu js_toggler"><span class="icon-menu"></span><span class="hidden">Main Actions</span></a>
		<a href="#js_search" class="icon_link icon_link_search js_toggler"><span class="icon-magnifier"></span><span class="hidden">Search</span></a>

 		<form class="search" id="js_search" action="#" method="get" role="search">
			<fieldset class="no_mb">
				<legend>Search Gooeypress</legend>
				<label for="txtSearch" class="no_mb"><span class="hidden">Search</span><span class="icon-magnifier"></span></label>
				<input type="search" id="txtSearch" name="search" class="text no_mb" placeholder="Enter Search Term" />
				<button type="submit" class="btn">Search</button>
			</fieldset>
		</form>

		<div class="float_right">
			<a href="#js_mini_account" class="icon_link icon_link_avatar js_toggler"><span class="icon-avatar"></span><span class="hidden">Account Actions</span></a>

			<div class="mini_account" id="js_mini_account">
				
            @if (Auth::check())
	<p><a href="{{ url('account/profile') }}"><img src="{{ Auth::user()->present()->avatar(40) }}" /></a></p>
            @else
	<p><a href="{{ url('account/login') }}">Sign in</a> or <a href="{{ url('account/signup') }}" class="btn">Create Account</a></p>
            @endif



			</div>
		</div>
	</div>
</div>

<div class="main_actions" id="js_main_actions" data-toggle-allow-overflow-y="true">
		<div class="main_actions_inner std_width">
			<div class="float_left">
				<a href="#" class="btn btn_subdued btn_refine_categories"><span class="icon-menu"></span> Refine your categories</a>

				<ul class="reset menu main_actions_menu">
					<li class="dropdown_parent">
						<a href="#">Genre</a>
						<ul class="dropdown_menu">
							<li><a href="#">e-Commerce</a></li>
							<li><a href="#">Corporate</a></li>
							<li><a href="#">Blog</a></li>
							<li><a href="#">Charity</a></li>
							<li><a href="#">Small Business</a></li>
						</ul>
					</li>
					<li class="dropdown_parent">
						<a href="#">Style</a>
						<ul class="dropdown_menu">
							<li><a href="#">Flat</a></li>
							<li><a href="#">Skeuomorphic</a></li>
						</ul>
					</li>
					<li class="dropdown_parent">
						<a href="#">Layout</a>
						<ul class="dropdown_menu">
							<li><a href="#">Mobile</a></li>
							<li><a href="#">Desktop</a></li>
							<li><a href="#">Desktop &amp; Tablet</a></li>
							<li><a href="#">Responsive</a></li>
						</ul>
					</li>
				</ul>
			</div>

			<div class="saved_themes">
				<h3 class="saved_themes_heading"><a href="{{ url('/account/themes') }}"><span class="icon-pin"></span>Saved <span class="selecive_display_block">Themes</span></a></h3>
<?php $themes = Auth::user()->savedThemes->slice(0, 3); ?>
				<ul class="reset saved_theme_list">
    @foreach ($themes as $theme)
        <li class="inline_block"><a href="{{ url('/themes/remove/'. $theme->id) }}" class="btn btn_subdued btn_saved_theme"><span class="icon-pin"></span><span class="hidden">Remove</span> {{ $theme->title }} <span class="icon-cross"></span></a></li>
    @endforeach
				</ul>
			</div>
		</div>
</div>

<div id="content">
	<div id="content_inner" class="std_width ">
			
            @yield('content')
			
	</div>
</div>

<div class="footer">
	<div class="footer_inner std_width">
		<div class="connect">
			<h3 class="connect_heading">Connect Socially</h3>
			<ul class="menu connect_list grid_container connect_grid_container">
				<li class="grid_item connect_grid_item w25"><a href="#"><span class="icon icon-facebook"></span><span class="hidden">Facebook</span></a></li>
				<li class="grid_item connect_grid_item w25"><a href="#"><span class="icon icon-twitter"></span><span class="hidden">Twitter</span></a></li>
				<li class="grid_item connect_grid_item w25"><a href="#"><span class="icon icon-gplus"></span><span class="hidden">Google+</span></a></li>
				<li class="grid_item connect_grid_item w25"><a href="#"><span class="icon icon-pinterest"></span><span class="hidden">Pinterest</span></a></li>
			</ul>
		</div>

		<div role="contentinfo">
			<ul class="reset menu contentinfo_list">
				<li><a href="#">Terms &amp; Conditions</a></li>
				<li><a href="#">Advertise</a></li>
				<li><a href="#">Get in touch</a></li>
				<li><a href="#">Submit a theme</a></li>
			</ul>
			<p class="copyright">Concoted in London, UK. Copyright Gooeypress &copy; 2012-2014 </p>
		</div>
	</div>
</div>

<!--[if lt IE 9]>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="/js/jquery-1.11.0.min.js"><\/script>')</script>
	<script src="{{ asset('front/js/selectivizr.min.js') }}"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>-->
	<script>window.jQuery || document.write('<script src="{{ asset('front/js/jquery-2.1.0.min.js') }}"><\/script>')</script>
<!--<![endif]-->

<script src="{{ asset('front/js/build/all.js?v=140712105904') }}"></script>

@yield('scripts')

</body>
</html>
