@extends('user.layouts.kn247.master')
@section('title')
Dịch vụ
@endsection

@section('content')
<div class="container mt-4 mb-4">
    <div class="row col-md-12">
        <h3>{!! $title !!}</h3>
    </div>
    <div class="row col-md-12">{!! $content !!}</div>
</div>
@endsection