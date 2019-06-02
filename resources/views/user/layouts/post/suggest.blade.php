@if($suggest_post)
    @php
        $i=1;
    @endphp
    @foreach($suggest_post as $post)
    @php
        if($i > 3) break;
    @endphp
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('user.blog', [
            'blog_id' => data_get($post, 'id')
        ]) }}" class="a-block d-flex align-items-center height-md" style="background-image: url({{ asset('images/'.data_get($post, 'image_name', 'none.jpg')) }}); ">
            <div class="text">
                <div class="post-meta">
                    <span class="category">{{ data_get($post, 'category') }}</span>
                    <span class="mr-2">{{ data_get($post, 'create_from') }} </span> &bullet;
                    <span class="ml-2">
                        <span class="fa fa-comments"></span>
                        <span>{{ data_get($post, 'comments') }}</span>
                    </span>
                </div>
                <h3>{{ data_get($post, 'title') }}</h3>
            </div>
        </a>
    </div>
    @php
        $i++;
    @endphp
    @endforeach
@endif
