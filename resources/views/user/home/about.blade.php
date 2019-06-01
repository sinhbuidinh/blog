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
                @include('user.layouts.post.latest')
            </div>
            <!-- END main-content -->
            @if(!isset($without_sidebar))
            @include('user.layouts.sidebar')
            @endif
        </div>
    </div>
</section>
@endsection
