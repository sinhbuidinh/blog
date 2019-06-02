@extends('user.layouts.master')
@section('title')
About Page
@endsection

@section('content')
<section class="site-section">
    <div class="container">
        <div class="row blog-entries">
            @php
                $main_col_lg = isset($without_sidebar) ? ' col-lg-12' : ' col-lg-8';
            @endphp
            <div class="col-md-12{{ $main_col_lg }} main-content">
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-5">
                            <img src="{{ asset('images/my_photo.jpg') }}" 
                                alt="sinh's cover" class="img-fluid">
                        </p>
                        @include('user.layouts.selfinfo')
                    </div>
                </div>
                <div class="row mb-5 mt-5">
                    <div class="col-md-12 mb-5">
                        <h2>My Latest Posts</h2>
                    </div>
                    <div class="col-md-12">
                        @include('user.layouts.post.latest', [
                            'gen_post_entry' => true,
                        ])
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                    <nav aria-label="Page navigation" class="text-center">
                    <ul class="pagination">
                        <li class="page-item active">
                            <a class="page-link" href="#">Prev</a>
                        </li>
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
            @if(!isset($without_sidebar))
            @include('user.layouts.sidebar')
            @endif
        </div>
    </div>
</section>
@endsection
