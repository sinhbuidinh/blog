@if ($paginator->hasPages())
@if ($paginator->onFirstPage())
<a href="javascript:void(0)" class="common_pager_prev"></a>
@else
<a href="{{ $paginator->previousPageUrl() }}" class="common_pager_prev"></a>
@endif
<div class="common_pager_middle">
    <ul class="common_pager_list">
        @foreach ($elements as $element) 
            @if (is_string($element))
            <li class="common_pager_item active">
                <span>{{ $element }}</span>
            </li>
            @endif
            @if (is_array($element)) 
                @foreach ($element as $page => $url) 
                    @if ($page == $paginator->currentPage())
                    <li class="common_pager_item">
                        <a href="javascript:void(0)" class="common_pager_link active"><span>{{ $page }}</span></a>
                    </li>
                    @else
                    <li class="common_pager_item">
                        <a href="{{ $url }}" class="common_pager_link"><span>{{ $page }}</span></a>
                    </li>
                    @endif 
                @endforeach 
            @endif 
        @endforeach
    </ul>
</div>

@if ($paginator->hasMorePages())
<a href="{{ $paginator->nextPageUrl() }}" class="common_pager_next active"></a>
@else
<a href="javascript:void(0)" class="common_pager_next active"></a>
@endif
@endif