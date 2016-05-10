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
			
			<div><h2 class="page_sub_title">Advertise &gt; Dashboard</h2></div>
			
<div class="advert_box grid_container advert_box_grid_container">
    <div class="stats">
        <div class="grid_item advert_box_grid_item w33_at_960 w100_at_600">
            <p class="number">20,000</p>
            <p class="tip">Impressions you have left</p>
        </div>
        <div class="grid_item advert_box_grid_item w33_at_960 w100_at_600">
            <p class="number">22,000</p>
            <p class="tip">Impressions you have purchased</p>
        </div>
        <div class="grid_item advert_box_grid_item w33_at_960 w100_at_600">
            <p class="number">8,000</p>
            <p class="tip">Total clicks generated</p>
        </div>
    </div>
    <div class="quick_purchase">
        <form action="{{ url('adverts/choose') }}" method="get">
            <span class="price">${{ Config::get('adverts.price_per_unit') }}<span class="per">/cpm</span> &times;</span><input name="units" type="text" class="text units" placeholder="How many {{ Config::get('adverts.impressions_per_unit') }}'s" />
            <button class="btn_secondary">Buy Impressions Now</button>
        </form>
    </div>
</div>

<div class="advert_table">
    <table>
        <thead>
            <tr>
                <th>Purchase Date</th>
                <th>Impressions</th>
                <th>Type</th>
                <th>Invoice Link</th>
            </tr>
        </thead>
        <tbody>
@foreach($adverts as $advert)
            <tr>
                <td>{{ $advert->created_at }}</td>
                <td>{{ $advert->impression_budget }}</td>
                <td>{{ $advert->type }}</td>
                <td><a class="btn_secondary btn_tiny btn" href="{{ url('adverts/show/'. $advert->id) }}">View Transaction</a></td>
            </tr>
@endforeach
        </tbody>
    </table>
</div>

{{ $adverts->links('common.paginate') }}
			
		</div>


@stop
