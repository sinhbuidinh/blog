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
                        @foreach($category_posts as $info)
                            @include('user.layouts.post.intro', [
                                'big_intro' => true,
                                'item' => $info
                            ])
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
