<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Demo: {{ $theme->title }} | Gooeypress</title>

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('static/css/demo.css') }}"/>
</head>
<body>


    <div id="topbar">

        <div class="container">
            <a href="" class="theme-title">{{ $theme->title }}</a>

            <ul class="device-selector visible-lg-inline-block">
                <li class="label">Choose a device</li>
                <li><a id="desktop" href="#desktop"><i class="fa fa-desktop"></i></a></li>
                <li><a id="tablet" href="#tablet"><i class="fa fa-tablet"></i></a></li>
                <li><a id="mobile" href="#mobile"><i class="fa fa-mobile"></i></a></li>
            </ul>

            <ul class="actions">
                <li><a class="buy" href="{{ $theme->link_purchase }}">
                        @if($theme->price_type == 'membership')
                            <span class="visible-lg-inline">Join</span> ${{ $theme->price }}/m
                        @elseif($theme->price_type == 'fixed')
                            <span class="visible-lg-inline">Buy</span> ${{ $theme->price }}
                        @else
                            Free
                        @endif
                    </a></li>
                <li><a href="{{ $theme->present()->url }}">Back<span class="visible-lg-inline"> to Listing</span></a></li>
            </ul>

            <a class="direct" href="{{ $theme->link_demo }}">&times;</a>
        </div>

    </div>

    <div id="demo-container" class="container">
        <iframe id="demo-frame" src="{{ $theme->link_demo }}" frameborder="0"></iframe>
    </div>

    <!--[if lt IE 9]>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery-1.11.0.min.js"><\/script>')</script>
    <script src="http://gooeypress.app:8000/front/js/selectivizr.min.js"></script>
    <![endif]-->
    <!--[if gte IE 9]><!-->
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>-->
    <script>window.jQuery || document.write('<script src="http://gooeypress.app:8000/front/js/jquery-2.1.0.min.js"><\/script>')</script>
    <!--<![endif]-->

    <script>
        var widths = {
            'desktop': 1024,
            'tablet' : 768,
            'mobile' : 320
        };
        $('ul.device-selector li a').click(function(){
            var device = $(this).attr('id');

            $('#demo-container').width(widths[device]);
            $('ul.device-selector li a').removeClass('active');
            $(this).addClass('active');
        });
    </script>

</body>
</html>