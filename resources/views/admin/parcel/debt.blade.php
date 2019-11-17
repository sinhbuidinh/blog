@extends('admin.layouts.master') 
@section('title')
Debt
@endsection
@section('content')
@php
    $title = 'background-color: #d87611;';
    $border = 'border: 1px solid black;';
    $border_b = 'border-bottom: 1px solid black;';
    $border_t = 'border-top: 1px solid black;';
    $border_l = 'border-left: 1px solid black;';
    $border_r = 'border-right: 1px solid black;';
    $input_label = 'margin-right: 5px;';
    $top = 'vertical-align: top;';
    $nomargin = 'margin:0;';
@endphp
<div class="common_main_wrap">
    <div class="form_wrapper">
        <table width="100%">
            <thead>
                <tr>
                    <!-- logo -->
                    <td width="50%"><img style="width: 1px;" src="{{ public_path('images/logo_both.png') }}"></td>
                    <!-- parcel_code -->
                    <td width="50%" style="text-align: center;">{{ $parcel_code }}</td>
                </tr>
            </thead>
        </table>
        <table width="100%" style="{{ $border }}">
            <tbody>
                <tr style="{{ $title.$border_b.$border_t }}">
                    <td>Mã khách hàng</td>
                    <td>Thông tin người nhận</td>
                </tr>
                <tr>
                    <td width="50%" style="{{ $border_r }}">
                        <table id="customer_info" width="100%">
                            <!-- customer info -->
                            <tr>
                                <td colspan="2">
                                    <span>Họ tên người gửi: ..........................................................................................................................</span>
                                    <span>............................................................................................................................................................</span>
                                    <span>............................................................................................................................................................</span>
                                    <span>............................................................................................................................................................</span>
                                    <span>............................................................................................................................................................</span>
                                </td>
                            </tr>
                            <tr>
                                <td width="70%">Quận/Huyện: ..................................................................................</td>
                                <td width="30%">Mã: ...............................</td>
                            </tr>
                            <tr>
                                <td width="70%">Tỉnh Thành phố: ...........................................................................</td>
                                <td width="30%">Mã: ...............................</td>
                            </tr>
                            <tr>
                                <td width="70%">Tên liên hệ: .....................................................................................</td>
                                <td width="30%">SDT: .................................</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table id="receiver_info" width="100%">
                            <!-- receiver info -->
                            <tr>
                                <td colspan="2">
                                    <span>Họ tên người nhận: ..........................................................................................................................</span>
                                    <span>................................................................................................................................................................</span>
                                    <span>................................................................................................................................................................</span>
                                    <span>................................................................................................................................................................</span>
                                </td>
                            </tr>
                            <tr>
                                <td width="70%">Phường/Xã: ......................................................................................</td>
                                <td width="30%">Mã: ..................................</td>
                            </tr>
                            <tr>
                                <td width="70%">Quận/Huyện: ...................................................................................</td>
                                <td width="30%">Mã: ..................................</td>
                            </tr>
                            <tr>
                                <td width="70%">Tỉnh/Thành phố: .............................................................................</td>
                                <td width="30%">Mã: .................................</td>
                            </tr>
                            <tr>
                                <td colspan="2" width="100%">SDT liên hệ: ......................................................................................................................................</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="{{$border_b}}">
                        <table id="parcel_type" style="{{ $border_r }}"></table>
                    </td>
                    <td style="{{$border_b}}">
                        <table id="fee_sender"></table>
                    </td>
                </tr>
                <tr>
                    <td style="{{$top}}">
                        <table width="100%">
                            <thead>
                                <tr style="{{ $title.$border_r.$border_b }}">
                                    <td width="33%">Nội dung</td>
                                    <td width="33%">Dịch vụ gửi</td>
                                    <td width="33%">Dịch vụ gia tăng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="{{ $top.$border_b }}">
                                    <td width="33%" style="{{$border_r}}">
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                    </td>
                                    <td width="33%" style="{{$border_r}}">
                                        <label>
                                            <input type="checkbox" name="send_type" style="{{$input_label}}">
                                            Chuyển phát nhanh
                                        </label>
                                    </td>
                                    <td width="33%">
                                        <label>
                                            <input type="checkbox" name="services" style="{{$input_label}}">
                                            Bảo hiểm vận chuyển
                                        </label>
                                    </td>
                                </tr>
                                <tr style="{{ $title.$border_b }}">
                                    <td>Chỉ dẫn đặc biệt</td>
                                    <td colspan="2">Không phát được thì</td>
                                </tr>
                                <tr style="height: 100%;{{ $border_b }}">
                                    <td style="{{ $border_r }}">
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                    </td>
                                    <td colspan="2">
                                        <label>
                                            <input type="checkbox" name="fail[forward]" value="forward" style="{{$input_label}}">Chuyển tiếp
                                        </label>
                                        <label>
                                            <input type="checkbox" name="fail[refund]" style="{{$input_label}}">Chuyển hoàn
                                        </label>
                                        <label>
                                            <input type="checkbox" name="fail[destroy]" style="{{$input_label}}">Hủy
                                        </label>
                                        <label>
                                            <input type="checkbox" name="fail[contact]" style="{{$input_label}}">Báo người gửi
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table width="100%">
                            <thead>
                                <tr style="{{ $title.$border_l }}">
                                    <td width="30%">Phương thức thanh toán</td>
                                    <td width="30%">Nhân viên phát</td>
                                    <td width="40%">Chữ ký người nhận</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="{{ $border }}{{$top}}">
                                        <table width="100%" height="100%">
                                            <tr style="height: 40%">
                                                <td>
                                                    <label>
                                                        <input type="checkbox" name="pay[cash]" style="{{$input_label}}">Tiền mặt
                                                    </label><br>
                                                    <label>
                                                        <input type="checkbox" name="pay[debt]" style="{{$input_label}}">Ghi nợ
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr style="height: 60%">
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="{{ $border }}{{$top}}">
                                        <table width="100%">
                                            <tr style="{{ $border_b }}">
                                                <td>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                </td>
                                            </tr>
                                            <tr style="{{ $border_b }}">
                                                <td>
                                                    <p style="{{ $nomargin }}">Phát lần 1:</p>
                                                    <p style="padding-left:10px;{{ $nomargin }}">......h...... ....../....../..........</p>
                                                    <p style="{{ $nomargin }}">Lý do:</p>
                                                    <p style="padding-left:10px;{{ $nomargin }}">.......................................</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="{{ $nomargin }}">Phát lần 2:</p>
                                                    <p style="padding-left:10px;{{ $nomargin }}">......h...... ....../....../..........</p>
                                                    <p style="{{ $nomargin }}">Lý do:</p>
                                                    <p style="padding-left:10px;{{ $nomargin }}">.......................................</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="{{ $border }}{{$top}}">
                                        <table width="100%" height="100%">
                                            <tr>
                                                <td>(Đã kiểm tra không khiếu nại)</td>
                                            </tr>
                                            <tr style="{{ $border_b }}">
                                                <td>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ngày giờ nhận</td>
                                            </tr>
                                            <tr>
                                                <td>...h... .../.../.... ........</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr style="{{ $title }}">
                    <td colspan="2">Cam kết các điều khoản vận chuyển và không chứa hàng cấm hay vật nguy hiểm theo quy định của pháp luật hiện hành</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<style>
    
</style>
@endsection
