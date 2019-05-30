@if(!empty($small_intro))
<li>
    <a href="{{ route('user.blog', [
        'blog_id' => data_get($item, 'id')
    ]) }}">
        <img src="{{ asset('images/'.data_get($item, 'image_name')) }}" alt="Image placeholder" class="mr-4">
        <div class="text">
            <h4>{{ data_get($item, 'title') }}</h4>
            <div class="post-meta">
                <span class="mr-2">{{ data_get($item, 'date_from') }} </span> &bullet;
                <span class="ml-2"><span class="fa fa-comments"></span> {{ data_get($item, 'comments') }}</span>
            </div>
        </div>
    </a>
</li>
@elseif(!empty($big_intro))
<div class="post-entry-horzontal">
    <a href="{{ route('user.blog', [
        'blog_id' => data_get($item, 'id')
    ]) }}">
        <div class="image element-animate" data-animate-effect="fadeIn" style="background-image: url({{ asset('images/'.data_get($item, 'image_name')) }});"></div>
        <span class="text">
            <div class="post-meta">
                <span class="category">{{ data_get($item, 'category_name') }}</span>
                <span class="mr-2">{{ data_get($item, 'date_from') }}</span> &bullet;
                <span class="ml-2"><span class="fa fa-comments"></span> {{ data_get($item, 'comments') }}</span>
            </div>
            <h2>{{ data_get($item, 'title') }}</h2>
        </span>
    </a>
</div>
@endif
