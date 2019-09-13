<div class="header row col-sm-12">
    <div class="logo col-3 col-sm-2" data-url="{{ route('user.index') }}">
        <img src="{{ asset('images/logo_both.png') }}">
    </div>
    <div class="menu col-9 col-sm-10">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand note-title">Menu</a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#header_menu_dropdown" aria-controls="header_menu_dropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="header_menu_dropdown" aria-labelledby="header_menu_dropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown link</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>