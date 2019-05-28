<div class="post-entry-horzontal">
    <a href="#">
        <div class="image element-animate" data-animate-effect="fadeIn" style="background-image: url({{ asset('images/'.data_get($info, 'image_name')) }});"></div>
        <span class="text">
            <div class="post-meta">
                <span class="category">{{ data_get($info, 'category_name') }}</span>
                <span class="mr-2">{{ data_get($info, 'date_from') }}</span> &bullet;
                <span class="ml-2"><span class="fa fa-comments"></span> {{ data_get($info, 'comments') }}</span>
            </div>
            <h2>{{ data_get($info, 'detail') }}</h2>
        </span>
    </a>
</div>
