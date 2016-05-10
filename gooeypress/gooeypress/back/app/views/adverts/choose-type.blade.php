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
                <p style="margin-bottom:0;"><span class="number black">${{ Config::get('adverts.price_per_unit') }}<span class="per">/cpm</span> &times;</span>
                    <input name="units" type="text" class="text units" placeholder="How many {{ Config::get('adverts.impressions_per_unit') }}'s" style="height:2.4rem;margin-top:0.2rem;width:9rem;" /></p>
                <p class="tip">Or update with new amount <button class="btn_secondary btn_small">Update</button></p>
            </form>
        </div>
    </div>
    <div class="quick_purchase" style="text-align:center;">
        <h3>Please select if you want to create a promotion for a theme or product.</h3>
        <div class="grid_container advert_box_grid_container">
            <div class="grid_item advert_box_grid_item w50_at_960 w100_at_600">
                <a class="choose-type-link" href="{{ url('adverts/create/theme') }}">
                    <p class="highlight">Advertise your theme using a promoted placement.</p>
                    <img src="{{ asset('static/img/advert-theme.png') }}" />
                    <p class="tip">Choose this option if you want to promote your theme within the Gooeypress site.</p>
                </a>
            </div>
            <div class="grid_item advert_box_grid_item w50_at_960 w100_at_600">
                <a class="choose-type-link" href="{{ url('adverts/create/product') }}">
                    <p class="highlight">Advertise your product using a promoted image advert.</p>
                    <img src="{{ asset('static/img/advert-product.png') }}" />
                    <p class="tip">Choose this option if you want to promote a product within the Gooeypress site.</p>
                </a>
            </div>
        </div>
    </div>
</div>

			
			
		</div>


@stop
