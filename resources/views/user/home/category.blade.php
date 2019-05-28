@extends('user.layouts.master')
@section('title')
Category Page
@endsection

@section('content')
<section class="site-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-4">Category: Food</h2>
            </div>
        </div>
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <div class="row mb-5 mt-5">
                    <div class="col-md-12">
                        @php
                            $category_posts = [
                                [
                                    'image_name' => 'img_4.jpg',
                                    'category_name' => 'Food',
                                    'date_from' => 'March 15, 2018',
                                    'comments' => '3',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                                [
                                    'image_name' => 'img_5.jpg',
                                    'category_name' => 'Lifestyle',
                                    'date_from' => 'March 15, 2018',
                                    'comments' => '4',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                                [
                                    'image_name' => 'img_6.jpg',
                                    'category_name' => 'Travel',
                                    'date_from' => 'March 15, 2018',
                                    'comments' => '6',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                                [
                                    'image_name' => 'img_7.jpg',
                                    'category_name' => 'Food',
                                    'date_from' => 'March 12, 2018',
                                    'comments' => '5',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                                [
                                    'image_name' => 'img_8.jpg',
                                    'category_name' => 'Lifestyle',
                                    'date_from' => 'Jun 12, 2018',
                                    'comments' => '9',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                                [
                                    'image_name' => 'img_9.jpg',
                                    'category_name' => 'Travel',
                                    'date_from' => 'July 12, 2018',
                                    'comments' => '1',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                                [
                                    'image_name' => 'img_10.jpg',
                                    'category_name' => 'Travel',
                                    'date_from' => 'Jan 23, 2018',
                                    'comments' => '11',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                                [
                                    'image_name' => 'img_11.jpg',
                                    'category_name' => 'Lifestyle',
                                    'date_from' => 'Jan 23, 2018',
                                    'comments' => '8',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                                [
                                    'image_name' => 'img_12.jpg',
                                    'category_name' => 'Food',
                                    'date_from' => 'Jan 6, 2018',
                                    'comments' => '6',
                                    'detail' => 'There’s a Cool New Way for Men to Wear Socks and Sandals',
                                ],
                            ];
                        @endphp
                        @foreach($category_posts as $info)
                            @include('user.layouts.post.short_detail', $info)
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <nav aria-label="Page navigation" class="text-center">
                        <ul class="pagination">
                            <li class="page-item active"><a class="page-link" href="#">Prev</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- END main-content -->
            @include('user.layouts.sidebar')
        </div>
    </div>
</section>
@endsection
