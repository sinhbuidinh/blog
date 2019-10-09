<div class="header row col-sm-12">
    <div class="logo col-5 col-sm-2" data-url="{{ route('user.index') }}">
        <img src="{{ asset('images/logo_both.png') }}">
    </div>
    <div class="menu col-7 col-sm-10">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand note-title">Menu</a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#header_menu_dropdown" aria-controls="header_menu_dropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="header_menu_dropdown" aria-labelledby="header_menu_dropdown">
                <ul class="navbar-nav">
                    <li class="nav-item{{ isActiveClass('user.index') }}">
                        <a class="nav-link" href="{{ route('user.index') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item{{ isActiveClass('user.about') }}">
                        <a class="nav-link" href="{{ route('user.about') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item{{ isActiveClass('user.contact') }}">
                        <a class="nav-link" href="{{ route('user.contact') }}">Liên hệ</a>
                    </li>
                    <li class="nav-item dropdown{{ isActiveClass('user.service.cpn') }}{{ isActiveClass('user.service.quick') }}{{ isActiveClass('user.service.transport') }}">
                        <a class="nav-link dropdown-toggle" href="#" id="transfer-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dịch vụ</a>
                        <div class="dropdown-menu" aria-labelledby="transfer-dropdown">
                            <a class="dropdown-item{{ isActiveClass('user.service.cpn') }}" href="{{ route('user.service.cpn') }}">Chuyển Phát Nhanh(CPN)</a>
                            <a class="dropdown-item{{ isActiveClass('user.service.quick') }}" href="{{ route('user.service.quick') }}">Hỏa tốc(HT)</a>
                            <a class="dropdown-item{{ isActiveClass('user.service.transport') }}" href="{{ route('user.service.transport') }}">Vận tải(VT)</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        @php
                            $sp_active = '';
                            if (isActiveClass('user.support.full-time')
                                || isActiveClass('user.support.price-tbl')
                                || isActiveClass('user.support.gas-exchange')
                                || isActiveClass('user.support.gtgt')
                                || isActiveClass('user.support.transport')
                            ) {
                                $sp_active = ' active';
                            }
                        @endphp
                        <a class="nav-link dropdown-toggle{{ $sp_active }}" href="#" id="support-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hỗ trợ</a>
                        <div class="dropdown-menu" aria-labelledby="support-dropdown">
                            <a class="dropdown-item{{ isActiveClass('user.support.full-time') }}" href="{{ route('user.support.full-time') }}">Thời gian toàn trình</a>
                            <a class="dropdown-item{{ isActiveClass('user.support.price-tbl') }}" href="{{ route('user.support.price-tbl') }}">Bảng giá chuyển phát nhanh</a>
                            <a class="dropdown-item{{ isActiveClass('user.support.transport') }}" href="{{ route('user.support.transport') }}">Bảng giá vận tải</a>
                            <a class="dropdown-item{{ isActiveClass('user.support.gas-exchange') }}" href="{{ route('user.support.gas-exchange') }}">Phụ phí</a>
                            <a class="dropdown-item{{ isActiveClass('user.support.gtgt') }}" href="{{ route('user.support.gtgt') }}">Dịch vụ GTGT</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>