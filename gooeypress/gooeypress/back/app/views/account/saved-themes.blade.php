@extends('layouts.three-col')

@section('content')

<h1 class="page_title_primary">Account - <span class="h_alt">{{ $me->nicename }}</span></h1>

<div id="col_1">
	<div class="js_accordion" data-multiple="true">
        @include('account.sidebar', ['page' => 'themes'])
	</div>
</div>
<div id="col_3" role="aside">
    @include('account.activity-widget', [])
</div>

<div id="col_2" role="main">
    <div class="h1 page_title page_title_duplicate">Account - <span class="h_alt">{{ $me->nicename }}</span></div>
    
    <div><h2 class="page_sub_title">All Saved Themes</h2></div>

<ol class="list_style_none" start="1"> <!-- Change start value depending on which page you're on -->
@foreach($themes as $theme)
    <li class="panel saved_theme_panel panel_has_remove">
        <img class="saved_theme_panel_image" src="/shots/{{ $theme->screenshot }}-400x300.png" width="65" height="58" alt="{{ $theme->title }}" style="width:65px;" />
        <dl class="saved_theme_panel_dl">
            <dt><a href="{{ $theme->present()->url }}">{{ $theme->title }}</a></dt>
            <dd>By {{ $theme->vendor->name }}</dd>
        </dl>
        <a href="{{ url('themes/remove/'. $theme->id) }}" class="saved_theme_panel_remove js_saved_theme_panel_remove"><span class="icon-cross"></span><span class="hidden">Remove this saved theme</span></a>
    </li>
@endforeach
</ol>


{{ $themes->links('common.paginate') }}


</div><!-- #col_2 -->

@stop
