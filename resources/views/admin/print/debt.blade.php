@php
    $title = 'background-color:#d87611;';
    $border = 'border: 1px solid black;';
    $border_b = 'border-bottom: 1px solid black;';
    $border_t = 'border-top: 1px solid black;';
    $border_l = 'border-left: 1px solid black;';
    $border_r = 'border-right: 1px solid black;';
    $input_label = 'margin-right: 5px;';
    $top = 'vertical-align: top;';
    $nomargin = 'margin:0;';
    $padl = 'padding-left:5px;';
    $bold_text = 'font-weight: bold;';
@endphp
<div class="common_main_wrap">
    <p id="p_print" align="center"><button id="print">Print</button></p>
    <div class="form_wrapper" id="content_debt">
        <table width="100%">
            <thead>
                <tr>
                    <!-- logo -->
                    <td width="50%"><img style="width: 200px;" src="{{ asset('images/logo_both.png') }}"></td>
                    <!-- parcel_code -->
                    <td width="50%" style="text-align: center;">{!! $barcode ?? '' !!}{!! $code ?? '' !!}</td>
                </tr>
            </thead>
        </table>
        <table width="100%" style="{{ $border }}">
            <tbody>
                <tr style="{{ $title }}">
                    <td style="{{ $padl.$border_b.$border_r }}">Mã khách hàng</td>
                    <td style="{{ $padl.$border_b }}">Thông tin người nhận</td>
                </tr>
                <tr>
                    <td width="50%" style="{{ $border_r.$border_b }}">
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
                    <td width="50%" style="{{ $border_b }}">
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
                    <td style="{{$border_b.$border_r}}">
                        <table width="100%" id="parcel_type">
                            <tr style="{{ $top }}">
                                <td rowspan="2" width="33%" style="{{$border_r}}">
                                    <label>
                                        <input type="checkbox" name="parcel_type[document]" style="{{$input_label}}">
                                        Tài liệu
                                    </label><br>
                                    <label>
                                        <input type="checkbox" name="parcel_type[package]" style="{{$input_label}}">
                                        Hàng hóa
                                    </label>
                                </td>
                                <td width="33%" style="text-align: center;{{$border_r.$border_b}}">
                                    <p style="{{ $nomargin }}">Số kiện:</p>
                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                </td>
                                <td width="33%" style="text-align: center;{{$border_b}}">
                                    <p style="{{ $nomargin }}">Khối lượng(gram)</p>
                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    <p style="{{ $nomargin }}">Khối lượng quy đổi(kg):</p>
                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="{{$border_b.$top}}">
                        <table width="100%" id="fee_sender">
                            <tr>
                                <td style="width: 20%;{{ $border_r.$border_b }}">
                                    <p style="{{ $nomargin }}">Cước chính</p>
                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                </td>
                                <td style="{{ $border_r.$border_b }}"></td>
                                <td style="width: 20%;{{ $border_r.$border_b }}">
                                    <p style="{{ $nomargin }}">Tổng cộng</p>
                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                </td>
                                <td style="{{ $border_r.$border_b }}"></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;{{ $border_r }}">
                                    <p style="{{ $nomargin }}">Cước cộng thêm</p>
                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                </td>
                                <td style="{{ $border_r }}"></td>
                                <td style="width: 20%;{{ $border_r }}">
                                    <p style="{{ $nomargin }}">Tổng cước(VAT)</p>
                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                </td>
                                <td style="{{ $border_r }}"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="{{$top}}">
                        <table width="100%" style="border-spacing: 1px;">
                            <thead>
                                <tr style="{{ $title }}">
                                    <td style="{{ $padl.$border_r.$border_b }}" width="33%">Nội dung</td>
                                    <td style="{{ $padl.$border_r.$border_b }}" width="33%">Dịch vụ gửi</td>
                                    <td style="{{ $padl.$border_r.$border_b }}" width="33%">Dịch vụ gia tăng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="{{ $top }}">
                                    <td width="33%" style="{{$border_r.$border_b}}">
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                    </td>
                                    <td width="33%" style="{{$border_r.$border_b}}">
                                        <label>
                                            <input type="checkbox" name="send_type[quick]" style="{{$input_label}}">
                                            Chuyển phát nhanh
                                        </label><br>
                                        <label>
                                            <input type="checkbox" name="send_type[transport]" style="{{$input_label}}">
                                            Vận tải
                                        </label><br>
                                        <label>
                                            <input type="checkbox" name="send_type[cod]" style="{{$input_label}}">
                                            COD
                                        </label>
                                    </td>
                                    <td width="33%" style="{{$border_r.$border_b}}">
                                        <label>
                                            <input type="checkbox" name="services[package_in]" style="{{$input_label}}">
                                            Báo phát
                                        </label><br>
                                        <label>
                                            <input type="checkbox" name="services[alarm]" style="{{$input_label}}">
                                            Phát hẹn giờ
                                        </label><br>
                                        <label>
                                            <input type="checkbox" name="services[insurrance]" style="{{$input_label}}">
                                            Bảo hiểm vận chuyển
                                        </label><br>
                                        <label>
                                            <input type="checkbox" name="services[hand_over]" style="{{$input_label}}">
                                            Phát tận tay
                                        </label>
                                    </td>
                                </tr>
                                <tr style="{{ $title }}">
                                    <td style="{{ $padl.$border_b.$border_r }}" colspan="3">Không phát được thì</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="{{ $border_b.$border_r }}">
                                        <p style="{{ $nomargin }}">&nbsp;</p>
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
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                    </td>
                                </tr>
                                <tr style="{{ $title }}">
                                    <td colspan="3" style="{{ $padl.$border_b.$border_r }}">Chỉ dẫn đặc biệt</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="{{ $border_b.$border_r }}">
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p>&nbsp;</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="{{$top}}">
                        <table width="100%">
                            <thead>
                                <tr style="{{ $title }}">
                                    <td style="{{ $padl.$border_b.$border_r }}" width="30%">Phương thức thanh toán</td>
                                    <td style="{{ $padl.$border_b.$border_r }}" width="30%">Nhân viên phát</td>
                                    <td style="{{ $padl.$border_b.$border_r }}" width="40%">Chữ ký</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="{{ $top.$border_b.$border_r }}">
                                        <label>
                                            <input type="checkbox" name="pay[cash]" style="{{$input_label}}">Tiền mặt
                                        </label><br>
                                        <label>
                                            <input type="checkbox" name="pay[debt]" style="{{$input_label}}">Ghi nợ
                                        </label>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                        <p style="{{ $nomargin }}">&nbsp;</p>
                                    </td>
                                    <td style="{{ $top.$border_b.$border_r }}">
                                        <table width="100%">
                                            <tr>
                                                <td style="{{ $border_b }}">
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="{{ $border_b }}">
                                                    <p style="{{ $nomargin }}">Phát lần 1:</p>
                                                    <p style="padding-left:10px;{{ $nomargin }}">......h...... ....../....../..........</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                    <p style="{{ $nomargin }}">Lý do:</p>
                                                    <p style="padding-left:10px;{{ $nomargin }}">.......................................</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="{{ $nomargin }}">Phát lần 2:</p>
                                                    <p style="padding-left:10px;{{ $nomargin }}">......h...... ....../....../..........</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                    <p style="{{ $nomargin }}">Lý do:</p>
                                                    <p style="padding-left:10px;{{ $nomargin }}">.......................................</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="{{ $top.$border_b }}">
                                        <table width="100%" height="100%">
                                            <tr>
                                                <td>
                                                    <p style="{{ $nomargin . $bold_text }}">Người nhận</p>
                                                    <p style="{{ $nomargin }}">(Đã kiểm tra không khiếu nại)</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ngày giờ nhận</td>
                                            </tr>
                                            <tr>
                                                <td style="{{ $border_b }}">
                                                    <p style="padding-left:10px;{{ $nomargin }}">...h... .../.../.... ........</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="{{ $nomargin . $bold_text }}">Người gửi</p>
                                                    <p style="{{ $nomargin }}">(Đã kiểm tra không khiếu nại)</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                    <p style="{{ $nomargin }}">&nbsp;</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ngày giờ gửi</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;">...h... .../.../.... ........</td>
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
<script src="{{ asset('js/app.js') }}"></script>
<script lang='javascript'>
    $(document).ready(function(){
        $('#print').click(function(){
            $('#p_print').hide();
            window.print();
            $('#p_print').show();
        });
    });
</script>
