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
@if($advert->status == 'placed')
            <a class="remove" href="{{ url('adverts/show/'.$advert->id.'?action=cancel') }}"><i class="icon icon-close"></i></a>
@endif
            <div class="thumb"><img src="{{ asset('shots/'. $theme->screenshot .'-400x300.png') }}" /></div>
            <div class="details">
                <h5>{{ $theme->title }}</h5>
                <p>By {{$theme->vendor->name}}</p>
            </div>
        </div>

        <form action="{{ url('adverts/update/'. $advert->id) }}" method="post">

            <table class="order">
                <tr>
                    <th width="33%">Product</th>
                    <th>Unit Cost</th>
                    <th>QTY</th>
                    <th>Sub Total</th>
                    <th></th>
                    <!--<th></th>-->
                </tr>
                <tr>
                    <td>Theme Promotion <span class="gray">- {{ $advert->impression_budget }} Impressions</span></td>
                    <td>${{ $advert->price}}</td>
                    <td>
                        @if($advert->status == 'placed')
                            <input style="width:30px;" type="text" name="QTY" value="{{ $advert->qty }}" />
                        @else
                            {{$advert->qty}}
                        @endif
                    </td>
                    <td>${{ number_format($advert->gross, 0) }} </td>
                    <td>
                        @if($advert->status == 'placed')
                                <button class="btn_secondary btn_small">Update</button>
                        @else
                            -
                        @endif
                    </td>
                    <!--<td><a class="remove" href=""><i class="icon icon-close"></i></a></td>-->
                </tr>
                <tr class="compact">
                    <td colspan="3">Sub Total</td>
                    <td colspan="2">${{ $advert->gross }}</td>
                </tr>
                <tr class="compact">
                    <td colspan="3">Sales Tax</td>
                    <td colspan="2">$0</td>
                </tr>
                <tr class="strong">
                    <td colspan="3">Total</td>
                    <td colspan="2">${{ $advert->gross }}</td>
                </tr>
            </table>

        </form>
        @if($advert->status == 'placed')
        <form name="_xclick" action="{{ Config::get('adverts.gateway') }}" method="post" style="text-align:right;">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="{{ Config::get('adverts.paypalID') }}">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="item_name" value="Theme Promotion - {{ $advert->impression_budget }} Impressions">
            <input type="hidden" name="amount" value="{{ $advert->gross }}">
            <input type="hidden" name="custom" value="{{ $advert->id }}">

            <input type="hidden" name="notify_url" value="{{ url('adverts/notify/paypal') }}" />


            <button class="btn_secondary" type="submit">Pay by <i><strong>Pay</strong>Pal</i></button>
        </form>
        @endif

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
