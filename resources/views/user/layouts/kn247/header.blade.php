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
                        <a class="nav-link" href="{{ route('user.index') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.about') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.contact') }}">Liên hệ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="transfer-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Loại chuyển phát</a>
                        <div class="dropdown-menu" aria-labelledby="transfer-dropdown">
                            <a class="dropdown-item" href="#">Chuyển Phát Nhanh(CPN)</a>
                            <a class="dropdown-item" href="#">Hỏa tốc(HT)</a>
                            <a class="dropdown-item" href="#">Vận tải(VT)</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>