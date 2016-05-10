<?php

$current = $paginator->getCurrentPage();
$last = $paginator->getLastPage();

$start = max($current - 3, 1);
$stop  = min($current + 3, $last);

?>

@if ($last != 1)

<div class="pagination ">
	<p class="pagination_label">Page {{ $current }} of {{ $last }}</p>
	<ul class="list_style_none pagination_list">
@if($current == 1)
    <li><span href="#" class="pagination_control pagination_control_prev pagination_control_disabled">Previous</span></li>
@else
    <li><a href="{{ $paginator->getUrl($current - 1) }}" class="pagination_control pagination_control_prev">Previous</a></li>
@endif

@for($i = $start; $i <= $stop; $i++)
    <li><a href="{{ $paginator->getUrl($i) }}" class="pagination_page {{ $i == $current ? 'pagination_page_current' : '' }}">{{ $i }}</a></li>
@endfor

@if($current != $last)
    <li><a href="{{ $paginator->getUrl(max($current + 1, $last)) }}" class="pagination_control pagination_control_next">Next</a></li>
@else
    <li><span href="#" class="pagination_control pagination_control_next pagination_control_disabled">Next</span></li>
@endif
	</ul>
</div>

@endif
