@extends('user.layouts.kn247.master') 
@section('title')
Trang chủ | KN247Express
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/kn247/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kn247/guest-slider.css') }}">
@endsection
@section('content')
<hr/>
<div class="row col-md-12 content" style="padding-top: 2.5rem;">
    <div class="row col-md-12">
        @include('user.layouts.kn247.parcel-find')
    </div>
    <hr/>
    <div class="container">
        <div class="row col-md-12">
            <div class="col-md-5">
                <div class="carousel slide row col-sm-12" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('images/user/gioi-thieu-01.jpg') }}" alt="gioi-thieu-01">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h1>Giới thiệu</h1>
                <p>KN247 chuyên về các "giải pháp" chuyển phát nhanh tại Việt Nam.</p>
                <p>Đảm bảo:</p>
                <ul>
                    <li>Chính xác</li>
                    <li>Nhanh</li>
                    <li>Thân thiện</li>
                </ul>
                <p>KN247 có mạng lưới rộng khắp 63 tỉnh thành trên cả nước.</p>
                <p>Đảm bảo phục vụ khách hàng có nhu cầu vận chuyển:</p>
                <ul>
                    <li>Chứng từ</li>
                    <li>Bưu phẩm</li>
                    <li>Hàng hóa</li>
                </ul>
            </div>
        </div>
        <hr/>
        <h5>Dịch vụ</h5>
        <div class="row col-md-12 services">
            <div class="row col-md-4 item">
                <div class="row col-md-12 img">
                    <img class="d-block w-100" src="{{ asset('images/user/cpn.jpg') }}" alt="chuyen-phat-nhanh">
                </div>
                <div class="row col-md-12 title">
                    <h6>CPN trong nước</h6>
                </div>
                <div class="row col-md-12 memo">
                    <p>Hãy nhấc điện thoại và gọi cho KN247 khi bạn có nhu cầu gửi thư, quà, vận chuyển hóa đơn, hàng hóa. Dịch vụ của KN247 đáng tin cậy như chính bạn tự tay chuyển phát. Chúng tôi sẽ giúp các bạn chiếm được cảm tình của bạn bè, người thân và các đối tác làm ăn.</p>
                </div>
            </div>
            <div class="row col-md-4 item">
                <div class="row col-md-12 img">
                    <img class="d-block w-100" src="{{ asset('images/user/vantai.jpg') }}" alt="van-tai">
                </div>
                <div class="row col-md-12 title">
                    <h6>Vận tải đường bộ</h6>
                </div>
                <div class="row col-md-12 memo">
                    <p>Là dịch vụ vận chuyển hàng có trọng lượng lớn, có thời gian vận chuyển dài hơn dịch vụ chuyển phát nhanh (từ 2 đến 7 ngày làm việc), nhưng với chi phí rất hợp lý.</p>
                </div>
            </div>
        </div>
        <hr/>
        <h5>Khách hàng</h5>
        <hr class="mb-0">
        <div class="row col-md-12 customers">
            @include('user.layouts.kn247.guest-slider')
        </div>
        <hr class="mt-0 mb-0">
        <div class="row col-md-12">&nbsp;</div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('js/user/guest-slider.js') }}" type="text/javascript"></script>
@endsection
