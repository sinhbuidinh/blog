@extends('user.layouts.kn247.master') 
@section('title')
Error | Chưa assign tài khoản cho khách
@endsection

@section('content')
<div class="container mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Error</h1>
        </div>
    </div>
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> Chưa gán tài khoản cho khách hàng!!!
        <br> Không thể tạo vận đơn.
    </div>
</div>
@endsection
