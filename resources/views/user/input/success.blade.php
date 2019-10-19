@extends('user.layouts.kn247.master') 
@section('title')
Tạo vận đơn thành công | KN247
@endsection

@section('content')
<div class="container mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Tình trạng vận đơn</h1>
        </div>
    </div>
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Thành công!</strong> Tạo vận đơn thành công!!!
    </div>
    <div class="row">
        <a class="btn btn-primary" href="{{ route('user.input') }}">Tiếp tục tạo mới vận đơn</a>
    </div>
</div>
@endsection
