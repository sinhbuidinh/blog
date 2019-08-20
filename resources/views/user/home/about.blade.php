@extends('user.layouts.kn247.master')
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
                <div class="row mb-5 mt-5">
                    <div class="col-md-12 mb-3">
                        <h2>Giới thiệu KN 247 Express</h2>
                    </div>
                    <div class="col-md-12">KN247 là công ty chuyên về các giải pháp chuyển phát nhanh tại Việt Nam.<br><br>
                        KN247 hiểu rằng việc chuyển phát nhanh đóng vai trò quan rất quan trọng trong công việc kinh doanh của quý khách.<br>
                        KN247 mong muốn đem đến cho quý khách hàng một dịch vụ chuyển phát tốt nhất với thời gian vận chuyển nhanh nhất.<br><br>
                        Chúng tôi không ngừng nổ lực để trở thành công ty chuyển phát nhanh hàng đầu tại Việt Nam.<br>
                    </div>
                    <div class="col-md-12">KN247 có mạng lưới chuyển phát nhanh rộng khắp 63 tỉnh thành trên cả nước, hơn 200 quốc gia trên thế giới.<br>Đảm bảo phục vụ khách hàng có nhu cầu chuyển chứng từ ,bưu phẩm và hàng hóa đến bất kỳ địa điểm nào với thời gian nhanh nhất.</div>
                    <div class="col-md-12 mt-3">
                        <h2>CPN TRONG NƯỚC</h3>
                    </div>
                    <div class="col-md-12">Hãy nhấc điện thoại và gọi cho KN 247 khi bạn có nhu cầu gửi thư, quà, vận chuyển hóa đơn, hàng hóa.<br><br>Dịch vụ của KN247 đáng tin cậy như chính bạn tự tay chuyển phát.<br>Chúng tôi sẽ giúp các bạn chiếm được cảm tình của bạn bè, người thân và các đối tác làm ăn.</div>
                </div>
            </div>
            <!-- END main-content -->
        </div>
    </div>
</section>
@endsection
