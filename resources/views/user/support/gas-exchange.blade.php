@extends('user.layouts.kn247.master')
@section('title')
Phụ phí
@endsection

@section('content')
<div class="container mt-4 mb-4">
    <h3>Phụ phí nhiên liệu & tỉ giá</h3>
    <div class="row col-md-12">
        <ul>
            <li><b>Phụ phí vùng sâu, vùng xa:</b> 20% cước chính</li>
            <li><b>Phụ phí nhiên liệu:</b> 20% cước chính</li>
            <li><b>VAT:</b> 10% (cước chính + phí dịch vụ + PP Vùng sâu + PP Nhiên liệu)</li>
        </ul>
    </div>
    <h3>Ghi chú:</h1>
    <div class="row col-md-12">
        <ul>
            <li>Thành phố thuộc tỉnh là giá bình thường. Còn về huyện và xã thuộc tỉnh thành thì tính phụ phí vùng sâu, vùng xa.</li>
        </ul>
    </div>
</div>
@endsection