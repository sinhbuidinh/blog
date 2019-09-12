@extends('user.layouts.kn247.master') 
@section('title')
Trang chủ | KN247Express
@endsection
@section('style')
<style type="text/css">
    .carousel-item img {
        height: 300px;
    }
    @media only screen and (max-width: 600px) {
        .carousel-item img {
            height: 166px;
        }
    }
</style>
@endsection
@section('content')
<div class="row col-md-12 content" style="padding-top: 2.5rem;">
    <div class="col-md-12">
        @include('user.layouts.kn247.parcel-find')
    </div>
</div>
@endsection
