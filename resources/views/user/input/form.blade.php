@extends('user.layouts.kn247.master') 
@section('title')
Tạo vận đơn | KN247
@endsection
@section('style')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Tạo mới vận đơn</h1>
        </div>
    </div>
    @include('admin.layouts.session-message')
    <div class="row blog-entries">
        <div class="col-md-12 main-content file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('user_input.create') }}" id="parcel_form" method="post">
                <div class="hidden">
                    {{ csrf_field() }}
                    <input type="hidden" id="tax_value" value="10" />
                    <input type="hidden" id="parcel_type_pack" value="{{ config('setting.parcel_type.code.package') }}" />
                    <input type="hidden" id="parcel_type_doc" value="{{ config('setting.parcel_type.code.document') }}" />
                    <input type="hidden" id="service_type_quick" value="{{ config('setting.transfer_type.code.quick') }}" />
                    <input type="hidden" id="service_type_trans" value="{{ config('setting.transfer_type.code.transport') }}" />
                    <input type="hidden" id="fast_transfer_weight" value="{{ config('setting.fast_transfer_weight') }}" />
                    <input type="hidden" id="delivery_transfer_weight" value="{{ config('setting.delivery_transfer_weight') }}" />
                    @if($guest)
                    <input type="hidden" name="guest_id" id="guest_id" value="{{ data_get($guest, 'id') }}" />
                    <input type="hidden" name="guest_code" id="guest_code" value="{{ data_get($guest, 'guest_code', 'xxxx') }}" />
                    @endif
                </div>
                <div class="row col-sm-12 receiver_info">
                    <p class="file_form_top_title">{{ trans('label.receiver_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-6 my-auto">{{ trans('label.delivery_to_company_name') }}</div>
                        <div class="col-sm-6 my-auto">{{ trans('label.full_name') }}</div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6 my-auto">
                            <input type="text" class="full_width form-control" name="receiver_company" value="{{ old('receiver_company') }}">
                        </div>
                        <div class="col-sm-6 my-auto">
                            @php
                                $receiver_invalid = $errors->has('receiver') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $receiver_invalid }}" name="receiver" value="{{ old('receiver') }}">
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6 my-auto">{{ trans('label.provincial') }}</div>
                        <div class="col-sm-6 my-auto">{{ trans('label.tel') }}</div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6 my-auto" id="div_provinces">
                            @php
                                $province_invalid = $errors->has('province') ? ' is-invalid' : '';
                            @endphp
                            <select id="province" class="full_width search form-control{{ $province_invalid }}" name="province">
                                <option value="">{{ trans('label.please_choose') }}</option>
                                @if(!empty($provincials))
                                @foreach ($provincials as $code => $info)
                                    @php
                                        $check = '';
                                        if (old('province', -999) == $code) {
                                            $check = ' selected="selected"';
                                        }
                                    @endphp
                                    <option value="{{ $code }}" 
                                    data-districts="{{ route('district.by.province', $code) }}"
                                    data-display="{{ data_get($info, 'name_with_type') }}"
                                    {{ $check }}>{{ data_get($info, 'name_with_type') }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('province'))
                            <p class="common_form_error">
                                {{ $errors->first('province') }}
                            </p>
                            @endif
                        </div>
                        <div class="col-sm-6 my-auto">
                            @php
                                $receiver_tel_invalid = $errors->has('receiver_tel') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $receiver_tel_invalid }}" name="receiver_tel" value="{{ old('receiver_tel') }}">
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6 my-auto">{{ trans('label.district') }}</div>
                        <div class="col-sm-6 my-auto">{{ trans('label.ward') }}</div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6 my-auto" id="div_districts">
                            @php
                                $district_invalid = $errors->has('district') ? ' is-invalid' : '';
                            @endphp
                            <select name="district" class="full_width search form-control{{ $district_invalid }}" id="district">
                                <option value="">{{ trans('label.please_choose') }}</option>
                                @if(!empty($districts))
                                @foreach ($districts as $code => $district)
                                    @php
                                        $districted = '';
                                        if (old('district', -999) == $code) {
                                            $districted = ' selected="selected"';
                                        }
                                    @endphp
                                    <option value="{{ $code }}" 
                                    data-wards="/ajax/get_wards/{{ $code }}"
                                    data-display="{{ data_get($district, 'name_with_type') }}" {{$districted}}>{{ data_get($district, 'name_with_type') }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('district'))
                            <p class="common_form_error">
                                {{ $errors->first('district') }}
                            </p>
                            @endif
                        </div>
                        <div class="col-sm-6 my-auto" id="div_wards">
                            @php
                                $ward_invalid = $errors->has('ward') ? ' is-invalid' : '';
                            @endphp
                            <select name="ward" class="full_width search form-control{{ $ward_invalid }}" id="ward">
                                <option value="">{{ trans('label.please_choose') }}</option>
                                @if(!empty($wards))
                                @foreach ($wards as $code => $ward)
                                    @php
                                        $ward_checked = '';
                                        if (old('ward', -999) == $code) {
                                            $ward_checked = ' selected="selected"';
                                        }
                                    @endphp
                                    <option 
                                    data-display="{{ data_get($ward, 'name_with_type') }}" value="{{ $code }}" {{$ward_checked}}>{{ data_get($ward, 'name_with_type') }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ward'))
                            <p class="common_form_error">
                                {{ $errors->first('ward') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-6 my-auto">{{ trans('label.address') }}</div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-12 my-auto" id="div_address">
                            @php
                                $add_invalid = $errors->has('address') ? ' is-invalid' : '';
                            @endphp
                            <input type="text" class="full_width form-control{{ $add_invalid }}" name="address" id="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                            <p class="common_form_error">
                                {{ $errors->first('address') }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- package info -->
                <div class="row col-sm-12">
                    <p class="file_form_top_title">{{ trans('label.parcel_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-5 my-auto">{{ trans('label.parcel_type') }}</div>
                                <div class="col-sm-7 my-auto">
                                    @php
                                        $type_invalid = $errors->has('type') ? ' is-invalid' : '';
                                    @endphp
                                    <select name="type" class="full_width form-control{{ $type_invalid }}" id="parcel_type">
                                        <option value="">{{ trans('label.please_choose') }}</option>
                                        @if(!empty($parcel_types))
                                        @foreach ($parcel_types as $type_id => $type_name)
                                            @php
                                                $parcel_check = '';
                                                if (old('type', config('setting.parcel_type.code.document')) == $type_id) {
                                                    $parcel_check = ' selected="selected"';
                                                }
                                            @endphp
                                            <option value="{{ $type_id }}" {{$parcel_check}}>{{ $type_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('type'))
                                    <p class="common_form_error">
                                        {{ $errors->first('type') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4 my-auto">{{ trans('label.weight') }}</div>
                                <div class="col-sm-8 my-auto">
                                    @php
                                        $weight_invalid = $errors->has('weight') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" name="weight" 
                                        value="{{ old('weight', '0.100') }}" class="full_width form-control{{ $weight_invalid }}" id="weight" />
                                    @if ($errors->has('weight'))
                                    <p class="common_form_error">
                                        {{ $errors->first('weight') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4 my-auto">{{ trans('label.real_weight') }}</div>
                                <div class="col-sm-8 my-auto">
                                    @php
                                        $real_invalid = $errors->has('real_weight') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" name="real_weight" 
                                        value="{{ old('real_weight', '0.100') }}"
                                        id="real_weight" class="full_width form-control{{ $real_invalid }}" />
                                    @if ($errors->has('real_weight'))
                                    <p class="common_form_error">
                                        {{ $errors->first('real_weight') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-5 my-auto">{{ trans('label.long') }}</div>
                                <div class="col-sm-7 my-auto">
                                    @php
                                        $long_invalid = $errors->has('long') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" name="long" class="full_width form-control{{ $long_invalid }}"
                                        value="{{ old('long', 0.00) }}" id="long" />
                                    @if ($errors->has('long'))
                                    <p class="common_form_error">
                                        {{ $errors->first('long') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4 my-auto">{{ trans('label.wide') }}</div>
                                <div class="col-sm-8 my-auto">
                                    @php
                                        $wide_invalid = $errors->has('wide') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" name="wide" class="full_width form-control{{ $wide_invalid }}"
                                        value="{{ old('wide', '0.00') }}" id="wide" />
                                    @if ($errors->has('wide'))
                                    <p class="common_form_error">
                                        {{ $errors->first('wide') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4 my-auto">{{ trans('label.height') }}</div>
                                <div class="col-sm-8 my-auto">
                                    @php
                                        $height_invalid = $errors->has('height') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" name="height" value="{{ old('height', '0.00') }}"
                                        id="height" class="full_width form-control{{ $height_invalid }}" />
                                    @if ($errors->has('height'))
                                    <p class="common_form_error">
                                        {{ $errors->first('height') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-5 my-auto">{{ trans('label.type_transfer') }}</div>
                                <div class="col-sm-7 my-auto">
                                    @php
                                        $type_transfer_invalid = $errors->has('type_transfer') ? ' is-invalid' : '';
                                    @endphp
                                    <select name="type_transfer" class="full_width form-control{{ $type_transfer_invalid }}" id="service_type">
                                        <option value="">{{ trans('label.please_choose') }}</option>
                                        @if(!empty($transfer_types))
                                        @foreach ($transfer_types as $id => $name)
                                            @php
                                                $transfer_check = '';
                                                if (old('type_transfer', config('setting.transfer_type.code.quick')) == $id) {
                                                    $transfer_check = ' selected="selected"';
                                                }
                                            @endphp
                                            <option value="{{ $id }}" {{$transfer_check}}>{{ $name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('type_transfer'))
                                    <p class="common_form_error">
                                        {{ $errors->first('type_transfer') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4 my-auto">{{ trans('label.num_package') }}</div>
                                <div class="col-sm-8 my-auto">
                                    @php
                                        $num_invalid = $errors->has('num_package') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="number" name="num_package" value="{{ old('num_package', 1) }}" class="full_width form-control{{ $num_invalid }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="file_table_block row col-sm-12">
                    <p class="file_form_top_title">{{ trans('label.price_info') }}</p>
                    <div class="file_form_table_inner" style="width: 100%">
                        <table id="price_info" class="file_table">
                        <tbody>
                            <tr>
                                <td class="title my-auto">{{ trans('label.price') }}</td>
                                <td>
                                    @php
                                        $price_invalid = $errors->has('price') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" id="price" name="price" class="form-control{{ $price_invalid }}" value="{{ old('price') }}">
                                    @if ($errors->has('price'))
                                    <p class="common_form_error">
                                        {{ $errors->first('price') }}
                                    </p>
                                    @endif
                                </td>
                                <td class="title my-auto">{{ trans('label.cod') }}</td>
                                <td>
                                    <input type="text" id="cod" name="cod" class="form-control" value="{{ old('cod') }}">
                                    @if ($errors->has('cod'))
                                    <p class="common_form_error">
                                        {{ $errors->first('cod') }}
                                    </p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="title my-auto">{{ trans('label.refund') }}</td>
                                <td>
                                    <input type="text" id="refund" name="refund" class="form-control" value="{{ old('refund') }}">
                                    @if ($errors->has('refund'))
                                    <p class="common_form_error">
                                        {{ $errors->first('refund') }}
                                    </p>
                                    @endif
                                </td>
                                <td class="title my-auto">{{ trans('label.support_remote') }}</td>
                                <td class="rate_value">
                                    @php
                                        $remote_rate_invalid = $errors->has('support_remote_rate') ? ' is-invalid' : '';
                                        $remote_invalid = $errors->has('support_remote') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" class="form-control{{ $remote_rate_invalid }}" id="support_remote_rate" name="support_remote_rate" value="{{ data_get($default, 'support_remote') }}"> % <input type="text" class="form-control{{ $remote_invalid }}" id="support_remote" name="support_remote" value="{{ old('support_remote') }}">
                                    @if ($errors->has('support_remote'))
                                    <p class="common_form_error">
                                        {{ $errors->first('support_remote') }}
                                    </p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="title my-auto">{{ trans('label.forward') }}</td>
                                <td>
                                    <input type="text" id="forward" class="form-control" name="forward" value="{{ old('forward') }}">
                                </td>
                                <td class="title my-auto">{{ trans('label.support_gas') }}</td>
                                <td class="rate_value">
                                    @php
                                        $gas_rate_invalid = $errors->has('support_gas_rate') ? ' is-invalid' : '';
                                        $gas_invalid = $errors->has('support_gas') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" class="form-control{{ $gas_rate_invalid }}" id="support_gas_rate" name="support_gas_rate" value="{{ data_get($default, 'support_gas') }}"> % <input type="text" class="form-control{{ $gas_invalid }}" id="support_gas" name="support_gas" value="{{ old('support_gas') }}">
                                    @if ($errors->has('support_gas'))
                                    <p class="common_form_error">
                                        {{ $errors->first('support_gas') }}
                                    </p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="title my-auto">{{ trans('label.vat') }}</td>
                                <td class="rate_value">
                                    @php
                                        $vat_rate_invalid = $errors->has('vat') ? ' is-invalid' : '';
                                        $vat_invalid = $errors->has('price_vat') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" id="vat" name="vat" class="form-control{{ $vat_rate_invalid }}" value="{{ data_get($default, 'vat') }}"> % <input type="text" name="price_vat" id="price_vat" class="form-control{{ $vat_invalid }}" value="{{ old('price_vat') }}">
                                    @if ($errors->has('price_vat'))
                                    <p class="common_form_error">
                                        {{ $errors->first('price_vat') }}
                                    </p>
                                    @endif
                                </td>
                                <td class="title bold my-auto">{{ trans('label.total') }}</td>
                                <td>
                                    @php
                                        $total_invalid = $errors->has('total') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" id="total" class="form-control{{ $total_invalid }}" name="total" value="{{ old('total') }}">
                                    @if ($errors->has('total'))
                                    <p class="common_form_error">
                                        {{ $errors->first('total') }}
                                    </p>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="row col-sm-12">
                    <p class="file_form_top_title">{{ trans('label.note') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-5">
                            <textarea class="form-control" id="note" name="note">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- button action -->
                <div class="form_btn_area center mt-4">
                    <button class="btn btn-primary" id="create_parcel" type="button">{{ trans('label.create') }}</button>
                </div>
                <div style="display:none;">
                    <input type="hidden" id="url_get_price" value="{{ route('ajax.calculate.price') }}">
                    <input type="hidden" name="cal_remote" id="cal_remote" value="{{ old('cal_remote', 0) }}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{ asset('js/admin/parcel.js') }}"></script>
<script src="{{ asset('js/address.js') }}"></script>
@endsection
