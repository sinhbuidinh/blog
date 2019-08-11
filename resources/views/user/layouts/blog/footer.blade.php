<footer class="site-footer">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-4 footer-left">
                <h3>Paragraph</h3>
                <p>
                    <img src="{{ asset('images/img_1.jpg') }}"
                        alt="Image placeholder" class="img-fluid">
                </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, accusantium optio unde perferendis eum illum voluptatibus dolore tempora, consequatur minus asperiores temporibus reprehenderit.</p>
            </div>
            <div class="col-md-7 footer-right">
                <div class="row">
                    <div class="col-md-7">
                        @if($footer_latest)
                        <h3>Latest Post</h3>
                        <div class="post-entry-sidebar">
                            <ul>
                                @include('user.layouts.post.latest', [
                                    'gen_post_footer' => true
                                ])
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <div class="mb-5">
                            <h3>Quick Links</h3>
                            <ul class="list-unstyled quick-link-footer">
                                @include('user.layouts.menu', [
                                    'menu_footer' => true
                                ])
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h3>Social</h3>
                            <ul class="list-unstyled footer-social">
                                @include('user.layouts.social', [
                                    'have_li' => true,
                                ])
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('user.layouts.copyrights')
    </div>
</footer>
