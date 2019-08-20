<footer class="site-footer">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-4 footer-left">
                <h3>Giới thiệu</h3>
                <p>
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Image placeholder" class="img-fluid">
                </p>
                <p>KN247 có mạng lưới chuyển phát nhanh rộng khắp 63 tỉnh thành trên cả nước, hơn 200 quốc gia trên thế giới.</p>
            </div>
            <div class="col-md-7 footer-right">
                <div class="row">
                    <div class="col-md-7">
                        <h3>TÊN ĐẦY ĐỦ</h3>
                        <p>Công Ty TNHH MTV Kết Nối 247</p> 
                        <h3>TRỤ SỞ CHÍNH</h3>
                        <p>217 Lãnh Bình Thăng, Phường 12, Quận 11, TP HCM</p>
                        <p>SDT: 0909.317.297</p>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <h3>Menu</h3>
                        <div class="mb-5">
                            <ul class="list-unstyled quick-link-footer">
                                @include('user.layouts.kn247.menu', [
                                    'menu_footer' => true,
                                ])
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('user.layouts.kn247.copyrights')
    </div>
</footer>
