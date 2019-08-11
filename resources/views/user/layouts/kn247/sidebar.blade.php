<div class="col-md-12 col-lg-4 sidebar">
    <div class="sidebar-box search-form-wrap">
        <form action="#" class="search-form">
            <div class="form-group">
                <span class="icon fa fa-search"></span>
                <input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
            </div>
        </form>
    </div>
    <!-- END sidebar-box -->
    <div class="sidebar-box">
        <div class="bio text-center">
            <img src="{{ asset('images/my_photo.jpg') }}" 
                alt="sinh's cover" class="img-fluid">
            <div class="bio-body">
                @include('user.layouts.kn247.selfinfo')
                <p>
                    <a href="https://www.linkedin.com/in/sinhbui/" 
                        class="btn btn-primary btn-sm">Read my bio</a>
                </p>
                <p class="social">
                    @include('user.layouts.kn247.social')
                </p>
            </div>
        </div>
    </div>
    <!-- END sidebar-box -->    
    <div class="sidebar-box">
        @include('user.layouts.post.popular', [
            'populars' => $popular_post
        ])
    </div>
    <!-- END sidebar-box -->

    <!-- START categories -->
    <div class="sidebar-box">
        @include('user.layouts.kn247.categories', ['is_sidebar' => true])
    </div>
    <!-- END categories -->
</div>
