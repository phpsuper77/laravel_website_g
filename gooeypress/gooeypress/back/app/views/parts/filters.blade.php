<div id="filters" class="hide"><div class="filters-content">

    <a class="close dim" href="#"><i class="fa fa-list-ul"></i></a>

    <h2 class="filters-title">Filter Themes</h2>

    <ul id="filters-top" class="filters-top">
        <li><a href="#price-tab"><i class="fa fa-usd"></i> Price
            @if(count($prices)) <span class="tip">{{ count($prices) }}</span> @endif
            </a>
            <ul id="price-tab" class="filters-sub">
                @foreach($all_prices as $index => $price)
                <li {{ in_array($index, $prices) ? 'class="enabled"' : '' }}><a href="{{ filter_link($searchFilter, 'price', $index) }}">{{ $price['label'] }} </a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="#"><i class="fa fa-desktop"></i> Layout
            @if(count($layouts)) <span class="tip">{{ count($layouts) }}</span> @endif
            </a>
            <ul class="filters-sub">
                @foreach($items['layouts'] as $index => $layout)
                    <li {{ in_array($layout['id'], $layouts) ? 'class="enabled"' : '' }}><a href="{{ filter_link($searchFilter, 'layout', $layout['id']) }}">{{ $layout['name'] }} </a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="#"><i class="fa fa-tablet"></i> Responsive</a>
            <ul class="filters-sub">
                <li {{ in_array(1, $responsives) ? 'class="enabled"' : '' }}><a href="{{ filter_link($searchFilter, 'responsive', 1) }}">Yes </a></li>
                <li {{ in_array(0, $responsives) ? 'class="enabled"' : '' }}><a href="{{ filter_link($searchFilter, 'responsive', 0) }}">No </a></li>
            </ul>
        </li>
        <li><a href="#"><i class="fa fa-tag"></i> Genre
            @if(count($genres)) <span class="tip">{{ count($genres) }}</span> @endif
            </a>
            <ul class="filters-sub">
                @foreach($items['genres'] as $index => $genre)
                    <li {{ in_array($genre['id'], $genres) ? 'class="enabled"' : '' }}><a href="{{ filter_link($searchFilter, 'genre', $genre['id']) }}">{{ $genre['name'] }} </a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="#"><i class="fa fa-magic"></i> Style
            @if(count($styles)) <span class="tip">{{ count($styles) }}</span> @endif
            </a>
            <ul class="filters-sub">
                @foreach($items['styles'] as $index => $style)
                    <li {{ in_array($style['id'], $styles) ? 'class="enabled"' : '' }}><a href="{{ filter_link($searchFilter, 'style', $style['id']) }}">{{ $style['name'] }} </a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="#"><i class="fa fa-lightbulb-o"></i> Features</a></li>
        <li><a href="#"><i class="fa fa-bar-chart-o"></i> Performance</a></li>
    </ul>

    <a class="reset" href="{{ route('themes.index') }}">Reset all filters
        @if($searchFilter->filterNumber())
            <span class="tip">{{ $searchFilter->filterNumber() }}</span>
        @endif
    </a>
</div><!-- .filters-content -->
</div><!-- #filters -->

@section('footer')
<script type="text/javascript">
    $('#btn-refine-filters, #filters a.close').click(function(){
        $('#filters').toggleClass('show').toggleClass('hide');
        return false;
    });

    $('#filters-top>li>a').click(function(){
        $(this).parent().toggleClass('active');
        return false;
    });
</script>
@stop
