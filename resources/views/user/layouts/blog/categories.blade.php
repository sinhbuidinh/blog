@if(!empty($is_sidebar))
<h3 class="heading">Categories</h3>
<ul class="categories">
    @foreach($categories as $category)
    <li>
        <a href="{{ data_get($category, 'route') }}">{{ data_get($category, 'name') }} <span>({{ data_get($category, 'count') }})</span>
        </a>
    </li>
    @endforeach
</ul>
@elseif(!empty($is_tag))
<h3 class="heading">Tags</h3>
<ul class="tags">
    @foreach($categories as $category)
    <li>
        <a href="{{ data_get($category, 'route') }}">{{ data_get($category, 'name') }}</a>
    </li>
    @endforeach
</ul>
@elseif(!empty($is_menu))
    @foreach($categories as $category)
    <a class="dropdown-item {{ isActiveClass(data_get($category, 'route_name'), data_get($category, 'route_params', [])) }}" 
        href="{{ data_get($category, 'route') }}">{{ data_get($category, 'name') }}</a>
    @endforeach
@endif
