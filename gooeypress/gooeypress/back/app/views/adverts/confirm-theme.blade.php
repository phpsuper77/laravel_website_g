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
			
			<div><h2 class="page_sub_title">Advertise &gt; Confirm Order</h2></div>
			
<div class="advert_box grid_container advert_box_grid_container">
    <div class="gray-panel">
        <h2>Payment &amp; Billing</h2>

        <p>Theme promotion of {{ $theme->title }}</p>

        <div class="theme-entry">
            <a class="remove" href="{{ url('adverts/order/theme?remove='. $theme->hash) }}"><i class="icon icon-close"></i></a>
            <div class="thumb"><img src="{{ asset('shots/'. $theme->screenshot .'-400x300.png') }}" /></div>
            <div class="details">
                <h5>{{ $theme->title }}</h5>
                <p>By {{$theme->vendor->name}}</p>
            </div>
        </div>

        <form action="{{ url('adverts/confirm/theme') }}" method="post">
<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="theme_hash" value="{{ $theme->hash }}" />
            <input type="hidden" name="units" value="{{ $units }}" />


<table class="order">
    <tr>
        <td>Product</td>
        <td>Unit Cost</td>
        <td>QTY</td>
        <td>Sub Total</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Theme Promotion <span class="gray">- {{ $units * Config::get('adverts.impressions_per_unit') }} Impressions</span></td>
        <td>${{ Config::get('adverts.price_per_unit' ) }}</td>
        <td><input style="width:30px;" type="text" name="QTY" value="{{ $units }}" /></td>
        <td>${{ number_format(Config::get('adverts.price_per_unit') * $units) }} </td>
        <td><button class="btn_secondary btn_small">Update</button></td>
        <td><a href=""><i class="icon icon-close"></i></a></td>
    </tr>
</table>



            <button class="btn_secondary" type="submit">Pay by <i><strong>Pay</strong>Pal</i></button>

        </form>

    </div>
</div>

			
			
		</div><!-- #col_2 -->


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
