@extends('user.layouts.kn247.master')
@section('title')
Single blog Page
@endsection

@section('content')
<section class="site-section py-lg">
    <div class="container">
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <h1 class="mb-4">There’s a Cool New Way for Men to Wear Socks and Sandals</h1>
                <div class="post-meta">
                    <span class="category">Food</span>
                    <span class="mr-2">March 15, 2018 </span> &bullet;
                    <span class="ml-2">
                        <span class="fa fa-comments"></span> 3
                    </span>
                </div>
                <div class="post-content-body">
                    <p>Lorem ipsum dolor sit amet, consectetur.</p>
                    <p>Sint ab voluptates itaque, ipsum porro.</p>
                    <p>Quis eius aspernatur, eaque culpa cumque reiciendis.</p>
                    <div class="row mb-5">
                        <div class="col-md-12 mb-4 element-animate">
                            <img src="{{ asset('images/img_7.jpg') }}" alt="Image placeholder" class="img-fluid">
                        </div>
                        <div class="col-md-6 mb-4 element-animate">
                            <img src="{{ asset('images/img_9.jpg') }}" alt="Image placeholder" class="img-fluid">
                        </div>
                        <div class="col-md-6 mb-4 element-animate">
                            <img src="{{ asset('images/img_11.jpg') }}" alt="Image placeholder" class="img-fluid">
                        </div>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur.</p>
                    <p>Sint ab voluptates itaque, ipsum porro.</p>
                    <p>Quis eius aspernatur, eaque culpa cumque reiciendis.</p>
                </div>

                <div class="pt-5">
                    <p>
                        @include('user.layouts.post.category')
                        <br/>
                        @include('user.layouts.post.tag')
                    </p>
                </div>

                <div class="pt-5">
                    @include('user.layouts.post.comment_list')
                    @include('user.layouts.post.comment_new')
                </div>
            </div>
            <!-- END main-content -->

            @include('user.layouts.kn247.sidebar')
            <!-- END sidebar -->
        </div>
    </div>
</section>

<section class="py-5">
    @include('user.layouts.post.related')
</section>
@endsection
