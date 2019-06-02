@if(isset($gen_post_entry))
    @foreach($all_latest_post as $post)
    <div class="post-entry-horzontal">
        <a href="{{ route('user.blog', ['blog_id' => data_get($post, 'id')]) }}">
            <div class="image" 
                style="background-image: url({{ asset('images/'.data_get($post, 'image_name')) }});"></div>
            <span class="text">
                <div class="post-meta">
                    <span class="category">{{ data_get($post, 'category') }}</span>
                    <span class="mr-2">{{ data_get($post, 'create_from') }} </span> &bullet;
                    <span class="ml-2"><span class="fa fa-comments"></span> {{ data_get($post, 'comments') }}</span>
                </div>
                <h2>{{ data_get($post, 'title') }}</h2>
            </span>
        </a>
    </div>
    <!-- END post -->
    @endforeach
@elseif($gen_post_footer)
    @foreach($footer_latest as $post)
    <li>
        <a href="{{ route('user.blog', ['blog_id' => data_get($post, 'id')]) }}">
            <img src="{{ asset('images/'.data_get($post, 'image_name')) }}" alt="post-title" class="mr-4">
            <div class="text">
                <h4>{{ data_get($post, 'title') }}</h4>
                <div class="post-meta">
                    <span class="mr-2">{{ data_get($post, 'create_from') }} </span> &bullet;
                    <span class="ml-2"><span class="fa fa-comments"></span> {{ data_get($post, 'comments') }}</span>
                </div>
            </div>
        </a>
    </li>
    @endforeach
@endif
