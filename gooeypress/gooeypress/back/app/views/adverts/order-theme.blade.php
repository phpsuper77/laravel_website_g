@extends('layouts.three-col')

@section('content')
		<h1 class="page_title_primary">Account - <span class="h_alt">{{ $me->nicename }}</span></h1>
		
<div id="col_1">
	<div class="js_accordion" data-multiple="true">
        @include('account.sidebar', ['page' => 'adverts'])
	</div>
</div>
		
<div id="col_3" role="aside">
    @include('account.activity-widget', [])
</div>

		<div id="col_2" role="main">
			<div class="h1 page_title_duplicate">Account - <span class="h_alt">{{ $me->nicename }}</span></div>
			
			<div><h2 class="page_sub_title">Advertise &gt; Select Advert Type</h2></div>
			
<div class="advert_box grid_container advert_box_grid_container">
    <div class="stats">
        <div class="grid_item advert_box_grid_item w50_at_960 w100_at_600">
            <p><span class="number">{{ number_format($units * Config::get('adverts.impressions_per_unit'), 0) }}</span> <span class="number black">(${{ number_format($units * Config::get('adverts.price_per_unit'), 0) }})</span></p>
            <p class="tip">Impressions you would like to buy.</p>
        </div>
        <div class="grid_item advert_box_grid_item w50_at_960 w100_at_600">
            <form action="{{ url('adverts/choose') }}" method="get">
                <input type="hidden" name="action" value="theme" />
                <p style="margin-bottom:0;"><span class="number black">${{ Config::get('adverts.price_per_unit') }}<span class="per">/cpm</span> &times;</span>
                    <input name="units" type="text" class="text units" placeholder="How many {{ Config::get('adverts.impressions_per_unit') }}'s" style="height:2.4rem;margin-top:0.2rem;width:9rem;" /></p>
                <p class="tip">Or update with new amount <button class="btn_secondary btn_small">Update</button></p>
            </form>
        </div>
    </div>
    <div class="gray-panel">
        <h4 class="toggle-heading">Enter URL of theme you would like to promote.</h4>
        <form id="search-theme-form" action="{{ url('adverts/create/theme') }}" method="post" class="theme-search">
            <p>Enter the URL of the theme as listed on gooeypress site.</p>
            <fieldset>
                <label for="ipt-search" class="no_mb"><span class="hidden">Search</span><span class="icon-magnifier"></span></label>
                <input type="search" id="ipt-search" name="theme_url" class="text" />
                <button type="submit" class="btn btn_secondary">Find Theme</button>
            </fieldset>
        </form>
@if ($theme != NULL)
        <form action="{{ url('adverts/store') }}" method="post">

            <input type="hidden" name="type" value="theme" />
            <input type="hidden" name="theme_hash" value="{{ $theme->hash }}" />
            <input type="hidden" name="units" value="{{ $units }}" />

            <div class="theme-entry">
                <a class="remove" href="{{ url('adverts/create/theme?remove='. $theme->hash) }}"><i class="icon icon-close"></i></a>
                <div class="thumb"><img src="{{ asset('shots/'. $theme->screenshot .'-400x300.png') }}" /></div>
                <div class="details">
                    <h5>{{ $theme->title }}</h5>
                    <p>By {{$theme->vendor->name}}</p>
                </div>
            </div>

            <button class="btn_secondary" type="submit">Add Theme to Order</button>

        </form>
@elseif (Request::isMethod('post'))
        <p>Theme not found</p>
@endif

        <div class="spacer"><label><span>Or</span></label></div>

        <h4 class="toggle-heading">Add a new theme to the database.</h4>
        <p>If you can't find your theme on Gooeypress then simply fill out the form below and we will add it to the current database of themes.</p>
        <form id="add-new-theme-form" action="{{ url('adverts/confirm/theme') }}" method="get">
            <input type="hidden" name="type" value="theme" />
            <fieldset class="gray">
                <div class="f_row">
                    <label for="vendor">Vendor <em>*</em></label>
                    <div class="controls w_bp_large">
                        <input type="text" class="text w_bp_large" name="vendor" id="vendor" required aria-required placeholder="Vendor" />
                        <span class="description">The URL to the vendor who sells your theme on your behalf or if you sell you own themes your own URL.</span>
                    </div>
                </div>
                
                <div class="f_row">
                    <label for="author">Author <em>*</em></label>
                    <div class="controls w_bp_large">
                        <input type="text" class="text w_bp_large" name="author" id="author" placeholder="Author" required aria-required/>
                        <span class="description">The name of the person, company or site that built the theme.</span>
                    </div>
                </div>
                
                <div class="f_row">
                    <label for="theme-name">Theme Name <em>*</em></label>
                    <div class="controls w_bp_large">
                        <input type="text" class="text w_bp_large" name="theme[name]" id="theme-name" placeholder="Theme Name" required aria-required/>
                        <span class="description">The name of the theme it is commonly known by.</span>
                    </div>
                </div>
                
                <div class="f_row">
                    <label for="link_purchase">Theme Download or Purchase URL <em>*</em></label>
                    <div class="controls w_bp_large">
                        <input type="text" class="text w_bp_large" name="theme[link_purchase]" id="link_purchase" placeholder="URL to Purchase Page" required aria-required/>
                        <span class="description">Unaffiliated link to the purchase or download page.</span>
                    </div>
                </div>
                
                <div class="f_row">
                    <label for="link_demo">Theme Demo URL <em>*</em></label>
                    <div class="controls w_bp_large">
                        <input type="url" class="text w_bp_large" name="theme[link_demo]" id="link_demo" placeholder="Theme Demo URL" required aria-required />
                        <span class="description">Clean URL (no iFrame) to the theme demo, please note a theme must have a live demo to be listed on gooeypress.</span>
                    </div>
                </div>
                
                <div class="f_row">
                    <label for="responsive">Responsive <em>*</em></label>
                    <div class="controls w_bp_large">
                        <select id="responsive" name="theme[responsive]" class="w_bp_small" required aria-required>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        <span class="description">Is the theme reponsive to different viewports?</span>
                    </div>
                </div>
                
                <div class="f_row">
                    <label for="licence">Licence <em>*</em></label>
                    <div class="controls w_bp_large">
                        <input id="licence" class="text w_bp_large" type="text" name="licence" placeholder="Licence" />
                        <span class="description">What licence is the theme released under? e.g. GPL</span>
                    </div>
                </div>
<div class="f_row">
    <label for="description">Theme Description <em>*</em></label>
    <div class="controls w_bp_large">
        <textarea id="description" name="theme[notes]" style="width:100%" placeholder="Please enter a full description"></textarea>
        <span class="description">Please enter a full description no less than 300 words. A good example format is, Intro -&tg; describe the problem/task/need the theme solves -&gt; whats been built to do this -&gt; types of content templates -&gt; specific features -&gt; who should use it.</span>

    </div>
</div>
                

                <div class="btns dbl_mt">
        <button type="submit" class="btn_secondary" style="float:none;">Add Theme to Order</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>

			
			
		</div>


@stop

@section('scripts')

<script type="text/javascript">
$(function(){
    $('#btn-search').click(function(){
        var hash = $('#ipt-search').val();
        $.get("{{ url('api/theme') }}/" + hash, '', function(data){
            console.log(data);
        }, 'json');
    });
});
</script>

@stop
