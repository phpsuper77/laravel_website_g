@extends('layouts.three-col')

@section('content')

<h1 class="page_title_primary">Account - <span class="h_alt">{{ $me->nicename }}</span></h1>

<div id="col_1">
	<div class="js_accordion" data-multiple="true">
        @include('account.sidebar', ['page' => 'activity'])
	</div>
</div>
<div id="col_3" role="aside">
    @include('account.activity-widget', [])
</div>

<div id="col_2" role="main">
    <div class="h1 page_title page_title_duplicate">Account - <span class="h_alt">{{ $me->nicename }}</span></div>
    
    <div><h2 class="page_sub_title">All Activity</h2></div>
    
    <ol class="list_style_none" start="1"> <!-- Change start value depending on which page you're on -->

@foreach ($activities as $activity)
<li class="panel activity_panel panel_has_remove activity_panel_has_icon">
<?php switch($activity->activity){
case 'rate':
    $icon = 'star'; break;
case 'like':
    $icon = 'heart'; break;
case 'save':
    $icon = 'pin'; break;
default:
    $icon = 'heart';
}
    ?>
    <span class="activity_panel_icon icon-{{ $icon }}"></span>
    <p>You {{ $activity->activity }}d the theme
        <a href="{{  $activity->theme->present()->url }}">{{ $activity->theme->title }}</a>
        by <a href="#">{{ $activity->theme->vendor->name }}</a> on {{ date('F jS, Y', strtotime($activity->created_at)) }}.</p>
    <!--<a href="#" class="activity_panel_remove js_activity_panel_remove"><span class="icon-cross"></span><span class="hidden">Remove this activity</span></a>-->
</li>
@endforeach

    </ol>

{{ $activities->links('common.paginate') }}
    
</div><!-- #col_2 -->

@stop
