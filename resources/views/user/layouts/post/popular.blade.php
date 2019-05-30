<h3 class="heading">Popular Posts</h3>
<div class="post-entry-sidebar">
    <ul>
        @foreach($populars as $item)
            @include('user.layouts.post.intro', [
                'small_intro' => true,
                'item' => $item
            ])
        @endforeach
    </ul>
</div>