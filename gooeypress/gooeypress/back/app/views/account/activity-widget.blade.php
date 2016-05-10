<h3 class="h1 page_title page_aside_title">Recent Activity</h3>

<?php $activities = Auth::user()->activities->slice(0, 5);
$activities->load('theme.vendor'); ?>

<ol class="list_style_none">

@foreach ($activities as $activity)
    <li class="panel activity_panel panel_has_remove activity_panel_has_icon">
        <span class="activity_panel_icon icon-{{ $activity->icon() }}"></span>
        <p>You {{ $activity->activity }}d the theme <a href="{{ $activity->theme->present()->url }}">{{ $activity->theme->title }}</a> by <a href="{{ url('/vendor/'. $activity->theme->vendor->id ) }}">{{ $activity->theme->vendor->name }}</a>
            on {{ date('F jS, Y', strtotime($activity->created_at)) }}.</p>
    </li>
@endforeach

</ol>

