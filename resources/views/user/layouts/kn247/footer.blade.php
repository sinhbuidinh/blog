<footer class="site-footer">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-4 footer-left">
                <h3>Giới thiệu</h3>
                <p>
                    <img src="{{ asset('images/img_1.jpg') }}"
                        alt="Image placeholder" class="img-fluid">
                </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, accusantium optio unde perferendis eum illum voluptatibus dolore tempora, consequatur minus asperiores temporibus reprehenderit.</p>
            </div>
            <div class="col-md-7 footer-right">
                <div class="row">
                    <div class="col-md-7">
                        <h3>TRỤ SỞ CHÍNH</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, accusantium optio unde perferendis eum illum voluptatibus dolore tempora, consequatur minus asperiores temporibus reprehenderit.</p>
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
