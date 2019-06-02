@php
    $is_footer       = isset($menu_footer) ? true : false;
    $class_li        = 'nav-link' . ($is_footer ? '' : 'nav-item');
    $class_home      = 'nav-link' . ($is_footer ? '' : ' ' . isActiveClass('user.index'));
    $class_about     = 'nav-link' . ($is_footer ? '' : ' ' . isActiveClass('user.about'));
    $class_contact   = 'nav-link' . ($is_footer ? '' : ' ' . isActiveClass('user.contact'));
    $active_category = ('/'.request()->path() == route('user.category', ['type' => $type ?? ''], false)) ? ' active' : '';
    $class_category  = ' nav-link' . ($is_footer ? '' : $active_category);
@endphp
<li class="{{ $class_li }}">
    <a class="{{ $class_home }}" href="{{ route('user.index') }}">Home</a>
</li>
<li class="{{ $class_li }}">
    <a class="{{ $class_about }}" href="{{ route('user.about') }}">About</a>
</li>
<li class="{{ $class_li }}">
    <a class="{{ $class_contact }}" href="{{ route('user.contact') }}">Contact</a>
</li>
<li class="{{ $class_li }}">
    @if($is_footer)
        <a class="{{ $class_category }}" href="{{ route('user.category') }}">Categories</a>
    @else
        <a class="dropdown-toggle{{ $class_category }}" id="dropdown05"
            data-toggle="dropdown" aria-haspopup="true"
            href="#categories" aria-expanded="false">Categories</a>
        <div class="dropdown-menu" aria-labelledby="dropdown05">
            @include('user.layouts.categories', ['is_menu' => true])
        </div>
    @endif
</li>
