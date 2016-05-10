@extends('layouts.master')

@section('content')
<h1 class="page_title_primary">Browsing Themes - <span class="h_alt">1,422</span></h1>
		

<div id="col_2" role="main">
    <div class="h1 page_title_duplicate page_title">Browsing Themes - <span class="h_alt">1,422</span></div>
    
    <div class="browse_theme_sorter">
        <h4 class="browse_theme_sorter_heading">Sort by</h4>
        <ul class="list_style_none browse_theme_sorter_list">
            <li>{{ browse_theme_order_by_link('price', 'Price') }}</li>
            <li>{{ browse_theme_order_by_link('performance', 'Performance') }}</li>
            <li>{{ browse_theme_order_by_link('popular', 'Popular') }}</li>
            <li>{{ browse_theme_order_by_link('recent', 'Recently Added') }}</li>
        </ul>
    </div>

<ol class="std_mt grid_container browse_theme_grid_container" start="1"> <!-- Change start value depending on which page you're on -->

@foreach($themes as $theme)
    <li class="grid_item browse_theme_grid_item w50_at_600 w33_at_960 w25_at_1200">
        <div class="browse_theme_item">
            <a href="{{ $theme->present()->url }}" class="browse_theme_item_link">
                <img src="/shots/{{ $theme->screenshot }}-400x300.png" width="320" height="242" alt="TwitrCovers" />
				<!--<span class="theme_is_sponsored browse_theme_item_is_sponsored">Sponsored</span>-->
    @if($theme->price_type == 'free')
				<span class="theme_cost theme_is_free browse_theme_item_cost browse_theme_item_is_free"><span class="hidden">Cost:</span> Free</span>
    @elseif($theme->price_type == 'fixed')
				<span class="theme_cost theme_is_paid browse_theme_item_cost browse_theme_item_is_paid"><span class="hidden">Cost:</span> ${{$theme->price}}</span>
    @elseif($theme->price_type == 'membership')
				<span class="theme_cost theme_is_paid browse_theme_item_cost browse_theme_item_is_paid"><span class="hidden">Cost:</span> ${{$theme->price}}/m</span>
    @endif
            </a>
		
            <div class="browse_theme_item_content">
                <h3 class="browse_theme_item_heading">{{ $theme->title }}</h3>
                <a href="#unsaved-url" class="save_theme browse_theme_item_save js_save_theme" data-theme-is-saved="false"><span class="icon-pin"></span> Save</a>
                <p class="no_mb">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tortor nunc, egestas vitae lorem id, rhoncus mollis telluso [&hellip;]</p>
            </div>
		
            <div class="browse_theme_item_meta">
                <p class="likes browse_theme_item_likes">Likes <span class="icon-heart"></span> {{ $theme->likes_count }}</p>
                <p class="browse_theme_item_rating">
                    @foreach($theme->likedByUsers as $user)
                        <span class="avatar"><img src="{{ $user->present()->avatar(25) }}" /></span>
                    @endforeach
                </p>
            </div>

            <div class="browse_theme_item_hover">
                <div class="btns">
                    <a href="{{ $theme->present()->url }}" class="btn tooltip" data-preview="/shots/{{$theme->screenshot}}-800x600.png">Detailed View</a>
                    <a href="{{ url('/themes/save/'. $theme->id) }}" class="btn save">Save Theme</a>
                </div>
            </div>
        </div><!-- .browse_theme_item -->
    </li>
@endforeach
</ol>

    {{ $themes->links('common.paginate') }}

</div><!-- #col_2 -->

@stop
