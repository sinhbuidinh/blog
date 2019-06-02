<section class="site-section pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-theme home-slider">
                    @foreach($footer_latest as $post)
                    <div>
                        <a href="{{ route('user.blog', ['blog_id' => data_get($post, 'id')]) }}" 
                            class="a-block d-flex align-items-center height-lg" 
                            style="background-image: url({{ asset('images/'.data_get($post, 'image_name')) }}); ">
                        <div class="text half-to-full">
                            <div class="post-meta">
                                <span class="category">{{ data_get($post, 'category') }}</span>
                                <span class="mr-2">{{ data_get($post, 'create_from') }} </span> &bullet;
                                <span class="ml-2">
                                    <span class="fa fa-comments"></span>
                                    <span>{{ data_get($post, 'comments') }}</span>
                                </span>
                            </div>
                            <h3>{{ data_get($post, 'title') }}</h3>
                            <p>{{ data_get($post, 'short_body') }}</p>
                        </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if($have_suggest)
        <div class="row">
            @include('user.layouts.post.suggest', [
                'suggest_post' => $footer_latest ?? []
            ])
        </div>
        @endif
    </div>
</section>
