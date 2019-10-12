@extends('admin.layouts.master')
@section('title')
Dashboard
@endsection

@section('content')
<div class="row justify-content">
    <div class="col-md-12">
        <div class="title">Dashboard Index</div>
    </div>
    @include('admin.layouts.session-message')
</div>
@endsection
