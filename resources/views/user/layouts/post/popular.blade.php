<h3 class="heading">Popular Posts</h3>
<div class="post-entry-sidebar">
    <ul>
        @foreach($populars as $item)
            <li>
                <a href="">
                    <img src="{{ asset('images/img_1.jpg') }}" alt="Image placeholder" class="mr-4">
                    <div class="text">
                        <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                        <div class="post-meta">
                            <span class="mr-2">March 15, 2018 </span> &bullet;
                            <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>