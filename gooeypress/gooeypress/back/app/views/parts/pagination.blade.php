<?php

$start = $paginator->getCurrentPage() - 5;
$start = $start > 0 ? $start : 1;

$end = $start + 10;
$end = $end > $paginator->getLastPage() ? $paginator->getLastPage()
    : $end;

?>
@if ($paginator->getLastPage() > 1)
<div class="pagination">
  @if($paginator->getCurrentPage() != 1)
  <a href="{{ $paginator->getUrl($paginator->getCurrentPage() -1) }}">&laquo; Previous</a>
  @endif
  @for ($i = $start; $i <= $end; $i++)
  <a href="{{ $paginator->getUrl($i) }}"
    class="item{{ ($paginator->getCurrentPage() == $i) ? ' current' : '' }}">
      {{ $i }}
  </a>
  @endfor
  @if($paginator->getCurrentPage() != $paginator->getLastPage())
  <a href="{{ $paginator->getUrl($paginator->getCurrentPage()+1) }}">Next &raquo;</a>
  @endif
</div>  
@endif
