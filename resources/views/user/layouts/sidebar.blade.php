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
                @include('user.layouts.selfinfo')
                <p>
                    <a href="https://www.linkedin.com/in/sinhbui/" 
                        class="btn btn-primary btn-sm">Read my bio</a>
                </p>
                <p class="social">
                    @include('user.layouts.social')
                </p>
            </div>
        </div>
    </div>
    <!-- END sidebar-box -->    
    <div class="sidebar-box">
        @include('user.layouts.post.popular', [
            'populars' => [
                [
                    'id' => 1,
                    'image_name' => 'img_1.jpg',
                    'title' => 'Travel with me',
                    'date_from' => 'March 15, 2018',
                    'comments' => '2',
                ],
                [
                    'id' => 2,
                    'image_name' => 'img_2.jpg',
                    'title' => 'How to enjoy work',
                    'date_from' => 'April 2, 2018',
                    'comments' => '3',
                ],
                [
                    'id' => 3,
                    'image_name' => 'img_3.jpg',
                    'title' => 'How to enjoy life',
                    'date_from' => 'Jan 4, 2018',
                    'comments' => '4',
                ],
                [
                    'id' => 4,
                    'image_name' => 'img_4.jpg',
                    'title' => 'How to enjoy cooking',
                    'date_from' => 'July 5, 2018',
                    'comments' => '11',
                ],
            ]
        ])
    </div>
    <!-- END sidebar-box -->

    <!-- START categories -->
    <div class="sidebar-box">
        @include('user.layouts.categories', ['is_sidebar' => true])
    </div>
    <!-- END categories -->

    <!-- START tags -->
    <div class="sidebar-box">
        @include('user.layouts.categories', ['is_tag' => true])
    </div>
    <!-- END tags -->
</div>
