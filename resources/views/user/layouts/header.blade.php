<header role="banner">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-9 social">
                    @include('user.layouts.social')
                </div>
                <div class="col-3 search-top">
                    <form action="#search" class="search-top-form">
                        <span class="icon fa fa-search"></span>
                        <input type="text" id="search_keyword"
                            name="search_keyword"
                            placeholder="Type keyword to search...">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container logo-wrap">
        <div class="row pt-5">
            <div class="col-12 text-center">
                <a class="absolute-toggle d-block d-md-none" 
                    data-toggle="collapse" href="#navbarMenu" role="button" 
                    aria-expanded="false" aria-controls="navbarMenu">
                    <span class="burger-lines"></span>
                </a>
                <h1 class="site-logo"><a href="{{ route('user.index') }}">SINH</a></h1>
            </div>
        </div>
    </div>

    @php
        $nav_bt = isset($without_slider) ? ' none-bt' : '';
    @endphp
    <nav class="navbar navbar-expand-md navbar-light bg-light{{ $nav_bt }}">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ isActiveClass('user.index') }}" href="{{ route('user.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ isActiveClass('user.about') }}" href="{{ route('user.about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ isActiveClass('user.contact') }}" href="{{ route('user.contact') }}">Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        @php
                            $active_category = ('/'.request()->path() == route('user.category', ['type' => $type ?? ''], false)) ? ' active' : '';
                        @endphp
                        <a class="nav-link dropdown-toggle{{ $active_category }}" id="dropdown05"
                            data-toggle="dropdown" aria-haspopup="true"
                            href="#categories" aria-expanded="false">Categories</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown05">
                            @include('user.layouts.categories', ['is_menu' => true])
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
