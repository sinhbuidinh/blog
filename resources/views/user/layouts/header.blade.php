<header role="banner">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-9 social">
                    <a href="https://twitter.com/sinhbuidinh"><span class="fa fa-twitter"></span></a>
                    <a href="https://www.facebook.com/bluestart9d"><span class="fa fa-facebook"></span></a>
                    <a href="https://www.youtube.com/channel/UCA3QxFbaBpFryZpAhsBjiQQ"><span class="fa fa-youtube-play"></span></a>
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

    <nav class="navbar navbar-expand-md  navbar-light bg-light">
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
                        <a class="nav-link dropdown-toggle {{ isActiveClass('user.category') }}" id="dropdown05"
                            data-toggle="dropdown" aria-haspopup="true"
                            href="#categories" aria-expanded="false">Categories</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown05">
                            <a class="dropdown-item {{ isActiveClass('user.category', ['type' => 'code']) }}" href="{{ route('user.category', ['type' => 'code']) }}">Coding</a>
                            <a class="dropdown-item {{ isActiveClass('user.category', ['type' => 'food']) }}" href="{{ route('user.category', ['type' => 'food']) }}">Food</a>
                            <a class="dropdown-item {{ isActiveClass('user.category', ['type' => 'travel']) }}" href="{{ route('user.category', ['type' => 'travel']) }}">Travel</a>
                            <a class="dropdown-item {{ isActiveClass('user.category', ['type' => 'life']) }}" href="{{ route('user.category', ['type' => 'life']) }}">Lifestyle</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
