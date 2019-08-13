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
    <a class="{{ $class_home }}" href="{{ route('user.index') }}">Trang chủ</a>
</li>
<li class="{{ $class_li }}">
    <a class="{{ $class_about }}" href="{{ route('user.about') }}">Giới thiệu</a>
</li>
