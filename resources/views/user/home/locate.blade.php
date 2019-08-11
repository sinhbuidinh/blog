@extends('user.layouts.kn247.master') 
@section('title')
Tra cứu vận đơn | KN247Express - nhanh hơn bạn nghĩ
@endsection
@section('content')
<section class="site-section py-lg" style="padding-top: 2.5rem;">
    <div class="container">
        <div class="row blog-entries">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 title-locate">
                        <h1 class="mb-4">ĐỊNH VỊ BƯU PHẨM</h1>
                    </div>
                </div>
                <!-- package info -->
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="tracking-mailer-title">
                            <span class="mailer-name">Vận đơn: 30000455272</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">Loại dịch vụ</span>
                                    <span class="mailer-prop-value">Chuyển phát nhanh</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">Số kiện</span>
                                    <span class="mailer-prop-value">1</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">Dịch vụ cộng thêm</span>
                                    <span class="mailer-prop-value">Phát hẹn giờ</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">Người ký nhận</span>
                                    <span class="mailer-prop-value">_ANH</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">Nơi đi</span>
                                    <span class="mailer-prop-value address-mobile">Quận Tân Bình, HỒ CHÍ MINH</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mailer-prop-container mb-6">
                                    <span class="mailer-prop">Nơi đến</span>
                                    <span class="mailer-prop-value address-mobile">ĐẠT-Thị xã Bến Cát, BÌNH DƯƠNG</span>
                                </div>
                            </div>
                        </div>
                        <!-- img receiver -->
                        @if(!empty(data_get($package, 'img_receiver')))
                        <div class="row">
                            <div class="col-2">
                                <img src="http://c1.247post.vn/2019-08/2019-08-02/BCT-19-004/30000455272-1-ad78bc83-a646-48bc-a4a5-b650c1c62fbe.jpg" style="width: 100%;">
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <span class="title-list-tracking">Danh sách đơn hàng</span>
                        <div class="nav flex-column nav-pills list-mailers" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="30000455272" data-toggle="pill" href="javascript:void(0)" role="tab" aria-controls="30000455272" aria-selected="true">
                                <div class="row1">
                                    <!-- parcel code -->
                                    <div class="left-m">30000455272</div>
                                    <!-- status -->
                                    <div class="right-m">Phát thành công</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- status info -->
                <div class="row  hidden-xs hidden-sm visible-lg visible-md visible-xl d-none d-lg-block d-md-block">
                    <div class="col-md-12">
                        <ul class="checklist-tracking">
                            @if(!empty($trackings))
                            @foreach($trackings as $track)
                                <li class="{{ data_get($track, 'class') }}">
                                    <p>{{ data_get($track, 'date_time') }}</p>
                                    <a href="javascript:void(0)">
                                        <img src="{{ asset(data_get($track, 'status_image')) }}">
                                    </a>
                                    <p>{{ data_get($track, 'action') }}</p>
                                </li>
                            @endforeach
                            @endif
                            <li class="liner-check">
                                <p>01-08-2019</p>
                                <a href="javascript:void(0)"><img src="{{ asset('images/checked.png') }}"></a>
                                <p>Nhập hệ thống</p>
                            </li>
                            <li class="liner-checker-last">
                                <p>02-08-2019</p>
                                <a href="javascript:void(0)"><img src="{{ asset('images/checked_25.png') }}"></a>
                                <p>Đã phát</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- tracking info -->
                <div class="row mb-5">
                    <table class="table table-tracking-history">
                        <thead>
                            <tr>
                                <th scope="col">Ngày giờ</th>
                                <th scope="col">Địa điểm</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($histories))
                            @foreach($histories as $history))
                                <tr>
                                    <td>{{ data_get($history, 'action_time') }}</td>
                                    <td>{{ data_get($history, 'location') }}</td>
                                    <td>{{ data_get($history, 'status') }}</td>
                                    <td>{{ data_get($history, 'note') }}</td>
                                </tr>
                            @endforeach
                            @endif
                            <tr>
                                <td> 02/08/2019 10:43</td>
                                <td>Bưu cục Bến Cát - BÌNH DƯƠNG</td>
                                <td>Phát thành công</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td> 01/08/2019 18:53</td>
                                <td>Đại lý 3.1 - HỒ CHÍ MINH</td>
                                <td>Nhập hệ thống</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
