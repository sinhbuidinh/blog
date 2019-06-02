@php
    $is_footer       = isset($menu_footer) ? true : false;
    $class_li        = $is_footer ? '' : 'nav-item';
    $class_li_drop   = $is_footer ? '' : 'nav-item dropdown';
    $class_home      = $is_footer ? '' : 'nav-link ' . isActiveClass('user.index');
    $class_about     = $is_footer ? '' : 'nav-link ' . isActiveClass('user.about');
    $class_contact   = $is_footer ? '' : 'nav-link ' . isActiveClass('user.contact');
    $active_category = ('/'.request()->path() == route('user.category', ['type' => $type ?? ''], false)) ? ' active' : '';
    $class_category  = $is_footer ? '' : $active_category;
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
<li class="{{ $class_li_drop }}">
    @if($is_footer)
        <a class="nav-link{{ $class_category }}" href="{{ route('user.category') }}">Categories</a>
    @else
        <a class="nav-link dropdown-toggle{{ $class_category }}" id="dropdown05"
            data-toggle="dropdown" aria-haspopup="true"
            href="#categories" aria-expanded="false">Categories</a>
        <div class="dropdown-menu" aria-labelledby="dropdown05">
            @include('user.layouts.categories', ['is_menu' => true])
        </div>
    @endif
</li>
