@extends('admin.layouts.master')
@section('title'){{ trans('label.forward') }}@endsection
@section('head')
<style type="text/css">
    #parcels_tbl th, td {
        min-width: 120px;
    }
    input, select {
        padding: 0 10px;
    }
    .form-control {
        display: inline-block;
    }
    #price_info tr td.title {
        width: 100px;
    }
    #price_info tr td input {
        width: 261px;
    }
    #price_info tr td.bold {
        font-weight: bold;
    }
    #price_info td.rate_value input:first-child {
        width: 80px;
    }
    #price_info td.rate_value input:last-child {
        width: calc(100% - 80px);
        max-width: 160px;
    }
</style>
@endsection
@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">{{ trans('label.forward_parcel') }}</h1>
        </div>
        @include('admin.layouts.session-message')
        <div class="file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('forward.create') }}" id="forward_form" method="post">
                <div class="hidden">
                    {{ csrf_field() }}
                    <input type="hidden" id="is_forward" value="1">
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-2 bold-text no-padding my-auto">{{ trans('label.choose_parcel') }}</div>
                    <div class="col-sm-6 no-padding">
                        @php
                            $parcel_invalid = $errors->has('parcel') ? ' is-invalid' : '';
                        @endphp
                        <select class="form-control full_width{{ $parcel_invalid }}" name="parcel" id="parcel">
                            <option value="">{{ trans('label.please_choose') }}</option>
                            @if(!empty($parcels))
                            @foreach($parcels as $parcel)
                            <option data-code="{{ data_get($parcel, 'parcel_code') }}" 
                            data-id="{{ data_get($parcel, 'id') }}"
                            data-bill_code="{{ data_get($parcel, 'bill_code') }}"
                            data-type="{{ data_get($parcel, 'type') }}"
                            data-type_transfer="{{ data_get($parcel, 'type_transfer') }}"
                            data-weight="{{ data_get($parcel, 'weight') }}"
                            data-price="{{ data_get($parcel, 'price') }}"
                            data-refund="{{ data_get($parcel, 'refund') }}"
                            data-forward="{{ data_get($parcel, 'forward') }}"
                            data-vat="{{ data_get($parcel, 'vat') }}"
                            data-price_vat="{{ data_get($parcel, 'price_vat') }}"
                            data-cod="{{ data_get($parcel, 'cod') }}"
                            data-support_gas="{{ data_get($parcel, 'support_gas') }}"
                            data-support_remote="{{ data_get($parcel, 'support_remote') }}"
                            data-total="{{ data_get($parcel, 'total') }}"
                            data-total_service="{{ data_get($parcel, 'total_service') }}"
                            data-services="{{ data_get($parcel, 'services') }}"
                            value="{{ data_get($parcel, 'id') }}">{{ data_get($parcel, 'parcel_code') }}</option>
                            @endforeach
                            @endif
                        </select>
                        @if ($errors->has('parcel'))
                        <p class="common_form_error">
                            {{ $errors->first('parcel') }}
                        </p>
                        @endif
                    </div>
                </div>
                <p class="file_form_top_title">{{ trans('label.receiver_info') }}</p>
                <div class="row col-sm-12">
                    <div class="col-sm-6 my-auto">{{ trans('label.forward_name') }}</div>
                    <div class="col-sm-6 my-auto">{{ trans('label.forward_tel') }}</div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-6">
                        @php
                            $name_invalid = $errors->has('forward_name') ? ' is-invalid' : '';
                        @endphp
                        <input type="text" class="full_width form-control{{ $name_invalid }}" name="forward_name" id="forward_name" value="{{ old('forward_name') }}">
                        @if ($errors->has('forward_name'))
                        <p class="common_form_error">
                            {{ $errors->first('forward_name') }}
                        </p>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        @php
                            $tel_invalid = $errors->has('forward_tel') ? ' is-invalid' : '';
                        @endphp
                        <input type="text" class="full_width form-control{{ $tel_invalid }}" name="forward_tel" id="forward_tel" value="{{ old('forward_tel') }}">
                        @if ($errors->has('forward_tel'))
                        <p class="common_form_error">
                            {{ $errors->first('forward_tel') }}
                        </p>
                        @endif
                    </div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-6 my-auto">{{ trans('label.provincial') }}</div>
                    <div class="col-sm-6 my-auto">{{ trans('label.district') }}</div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-6" id="div_provinces">
                        @php
                            $province_invalid = $errors->has('province') ? ' is-invalid' : '';
                        @endphp
                        <select id="province" class="full_width form-control{{ $province_invalid }}" name="province">
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
                    <div class="col-sm-6" id="div_districts">
                        @php
                            $district_invalid = $errors->has('district') ? ' is-invalid' : '';
                        @endphp
                        <select name="district" class="full_width form-control{{ $district_invalid }}" id="district">
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
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-6 my-auto">{{ trans('label.ward') }}</div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-6" id="div_wards">
                        @php
                            $ward_invalid = $errors->has('ward') ? ' is-invalid' : '';
                        @endphp
                        <select name="ward" class="full_width form-control{{ $ward_invalid }}" id="ward">
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
                    <div class="col-sm-12 my-auto">{{ trans('label.address') }}</div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-12" id="div_address">
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
                                </td>
                                <td class="title my-auto">{{ trans('label.cod') }}</td>
                                <td>
                                    <input type="text" id="cod" name="cod" class="form-control" value="{{ old('cod') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="title my-auto">{{ trans('label.refund') }}</td>
                                <td>
                                    <input type="text" id="refund" name="refund" class="form-control" value="{{ old('refund') }}">
                                </td>
                                <td class="title my-auto">{{ trans('label.support_remote') }}</td>
                                <td class="rate_value">
                                    @php
                                        $remote_rate_invalid = $errors->has('support_remote_rate') ? ' is-invalid' : '';
                                        $remote_invalid = $errors->has('support_remote') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" class="form-control{{ $remote_rate_invalid }}" id="support_remote_rate" name="support_remote_rate" value="{{ data_get($default, 'support_remote') }}"> % <input type="text" class="form-control{{ $remote_invalid }}" id="support_remote" name="support_remote" value="{{ old('support_remote') }}">
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
                                </td>
                                <td class="title my-auto">{{ trans('label.total_service') }}</td>
                                <td>
                                    <input type="text" name="total_service" id="total_service" class="form-control" value="{{ old('total_service') }}">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="title bold my-auto">{{ trans('label.total') }}</td>
                                <td>
                                    @php
                                        $total_invalid = $errors->has('total') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" id="total" class="form-control{{ $total_invalid }}" name="total" value="{{ old('total') }}">
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-4">{{ trans('label.note') }}</div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-8">
                        <textarea class="form-control full_width" name="note" id="note">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="form_btn_area center">
                    <button class="btn btn-primary" id="forward_parcel" type="button">{{ trans('label.forward') }}</button>
                </div>
                <div style="display: none;">
                    <input type="hidden" id="cal_remote" value="0">
                    <input type="hidden" id="url_get_price" value="{{ route('ajax.calculate.price') }}">
                    <input type="hidden" id="type" name="type" value="{{ old('type') }}">
                    <input type="hidden" id="type_transfer" name="type_transfer" value="{{ old('type_transfer') }}">
                    <input type="hidden" id="weight" name="weight" value="{{ old('weight') }}">
                    <input type="hidden" id="price_vat_old" name="price_vat_old" value="{{ old('price_vat_old') }}">
                    <input type="hidden" id="support_remote_old" name="support_remote_old" value="{{ old('support_remote_old') }}">
                    <input type="hidden" id="support_gas_old" name="support_gas_old" value="{{ old('support_gas_old') }}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/address.js') }}"></script>
<script src="{{ asset('js/admin/forward.js') }}"></script>
@endsection
