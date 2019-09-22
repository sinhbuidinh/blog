@extends('user.layouts.kn247.master') 
@section('title')
Tra cứu vận đơn | KN247Express - nhanh hơn bạn nghĩ
@endsection
@section('style')
<style>
    .mb-6, .my-6 {
        margin-bottom: 4.5rem !important;
    }
    .text-center {
        text-align: center; 
        display: block;
    }
</style>
@endsection
@section('content')
<section class="site-section py-lg" style="padding-top: 2.5rem;">
    <div class="container">
        <div class="row blog-entries">
            <div class="col-md-12">
                @include('user.layouts.kn247.parcel-find')
                <div class="row">
                    <div class="col-md-12 title-locate">
                        <h1 class="mb-4">ĐỊNH VỊ BƯU PHẨM</h1>
                    </div>
                </div>
                <!-- package info -->
                @if(empty($parcel))
                <div class="row col-md-12 title-block mb-6 text-center">
                    <span>Không tìm thấy dữ liệu vận đơn</span>
                </div>
                @else
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="tracking-mailer-title">
                            <span class="mailer-name">{{ trans('label.parcel_code') }}: {{ $code }}</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">{{ trans('label.type_transfer') }}</span>
                                    <span class="mailer-prop-value">{{ data_get($parcel, 'transferName') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">{{ trans('label.num_package') }}</span>
                                    <span class="mailer-prop-value">{{ data_get($parcel, 'num_package') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">{{ trans('label.user_services_disp') }}</span>
                                    <span class="mailer-prop-value">{{ data_get($parcel, 'servicesDisplay') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mailer-prop-container">
                                    <span class="mailer-prop">{{ trans('label.receiver_signature') }}</span>
                                    <span class="mailer-prop-value">{{ data_get($parcel, 'receiverSignature') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mailer-prop-container mb-6">
                                    <span class="mailer-prop">{{ trans('label.destination') }}</span>
                                    <span class="mailer-prop-value address-mobile">{{ data_get($parcel, 'address') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- img receiver -->
                        @if(!empty(data_get($parcel, 'picture_confirm')))
                        <div class="row">
                            <div class="col-2">
                                <img src="{{ asset(data_get($parcel, 'picture_confirm')) }}" style="width: 100%;">
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
                                    <div class="left-m">{{ $code }}</div>
                                    <!-- status -->
                                    <div class="right-m">{{ data_get($parcel, 'statusName') }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- status info -->
                <div class="row  hidden-xs hidden-sm visible-lg visible-md visible-xl d-none d-lg-block d-md-block">
                    <div class="col-md-12">
                        <ul class="checklist-tracking" style="padding-left: 0;">
                            @if(!empty($tracks))
                            @php
                                $i = 1;
                                $nums = count($tracks);
                            @endphp
                            @foreach($tracks as $track)
                                @php
                                    $class = 'liner-check';
                                    if ($i == $nums) {
                                        $class = 'liner-checker-last';
                                    }
                                    $i++;
                                @endphp
                                <li class="{{ $class }}">
                                    <p>{{ data_get($track, 'date_time') }}</p>
                                    <a href="javascript:void(0)">
                                        <img src="{{ asset(data_get($track, 'imgTrack')) }}">
                                    </a>
                                    <p>{{ data_get($track, 'historyStatusName') }}</p>
                                </li>
                            @endforeach
                            @endif
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
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($histories))
                            @foreach($histories as $history)
                                <tr>
                                    <td>{{ data_get($history, 'date_time') }}</td>
                                    <td>{{ data_get($history, 'location') }}</td>
                                    <td>{!! data_get($history, 'historyStatusName') !!}</td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
