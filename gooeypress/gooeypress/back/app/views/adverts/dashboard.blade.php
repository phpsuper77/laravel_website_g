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

<div class="advert_chart">
    <h3>Stats for Time Period <span class="period">Dec 1st - Dec 28th</span>
    <a href="{{ url('adverts/orders') }}" class="btn btn_secondary">Purchase History</a>
</h3>
    <p class="meta">Impressions: <span class="number">254</span>, Clicks: <span class="number">24</span>, CTR: <span class="number">10.6%</span></p>
    <div id="advert-chart" style="height:240px;">
    </div>
</div>

<div class="advert_table">
    <table>
        <thead>
            <tr>
                <th>Time Period</th>
                <th>Impressions</th>
                <th>Clicks</th>
                <th>CTR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Dec 1st - Dec 28th</td>
                <td>2304</td>
                <td>326</td>
                <td>10.8%</td>
            </tr>
            <tr>
                <td>Dec 1st - Dec 28th</td>
                <td>2304</td>
                <td>326</td>
                <td>10.8%</td>
            </tr>
            <tr>
                <td>Dec 1st - Dec 28th</td>
                <td>2304</td>
                <td>326</td>
                <td>10.8%</td>
            </tr>
            <tr>
                <td>Dec 1st - Dec 28th</td>
                <td>2304</td>
                <td>326</td>
                <td>10.8%</td>
            </tr>
            <tr>
                <td>Dec 1st - Dec 28th</td>
                <td>2304</td>
                <td>326</td>
                <td>10.8%</td>
            </tr>
            <tr>
                <td>Dec 1st - Dec 28th</td>
                <td>2304</td>
                <td>326</td>
                <td>10.8%</td>
            </tr>
            <tr>
                <td>Dec 1st - Dec 28th</td>
                <td>2304</td>
                <td>326</td>
                <td>10.8%</td>
            </tr>
        </tbody>
    </table>
</div>
			
<div class="pagination ">
	<p class="pagination_label">Page 1 of 24</p>
	<ul class="list_style_none pagination_list">
		<li><span href="#" class="pagination_control pagination_control_prev pagination_control_disabled">Previous</span></li>
		<li><a href="#" class="pagination_page pagination_page_current">1</a></li>
		<li><a href="#" class="pagination_page">2</a></li>
		<li><a href="#" class="pagination_page">3</a></li>
		<li role="separator"><span class="pagination_divider">&hellip;</span></li>
		<li><a href="#" class="pagination_page">5</a></li>
		<li><a href="#" class="pagination_page">6</a></li>
		<li><a href="#" class="pagination_page">7</a></li>
		<li><a href="#" class="pagination_control pagination_control_next">Next</a></li>
	</ul>
</div>
			
		</div>


@stop

@section('scripts')
<script type="text/javascript" src="{{ asset('static/flot/jquery.flot.js') }}"></script>
<script type="text/javascript">
$(function(){

    var impressions = [];
    var clicks = [];

    for(var i = 0; i < 30; i++){
        impressions.push([i, i*50 % 600]);
        clicks.push([i, i*18 % 100]);
    }

    $.plot('#advert-chart', [
        { label : 'Impressions', data : impressions },
        { label : 'Clicks', data : clicks }
    ], {
        grid : {
            margin : { top: 0, bottom: 0, left: 0, right: 0 },
            borderColor: '#aaa', borderWidth: 1,
            markings : function(axes){
                var markings = [];
                var xaxis = axes.xaxis;
                for(var x = Math.floor(xaxis.min); x < xaxis.max; x += xaxis.tickSize){
                    var color = x % 2 ? '#fff' : '#fcfcfc';
                    markings.push({
                        xaxis: { from: x, to: x+xaxis.tickSize },
                        color: color
                    });
                }
                return markings;
            }
        },
        colors : ['#afd8f8', '#ee7951'],
        legend : { noColumns: 2, margin : 20 },
        series : { lines : { show : true }, points : {show : true} },
        xaxis : { tickSize : 3, color:'#e3e3e3'  },
        yaxis : { min : 0, max : 800 }
    });

});
</script>
@stop
