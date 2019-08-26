@extends('admin.layouts.master')
@section('title'){{ trans('message.edit_parcel') }}@endsection
@section('head')
<style type="text/css">
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
    .left .row,
    .right .row {
        margin: 5px;
    }
    #services_display {
        height: 120px;
    }
</style>
@endsection

@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">Sửa {{ trans('label.parcel') }}</h1>
        </div>
        @include('admin.layouts.session-message')
        <div class="file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('parcel.update', $parcel->id) }}" id="parcel_form" method="post">
                <div class="hidden">
                    {{ csrf_field() }}
                    <input type="hidden" id="tax_value" value="10" />
                </div>
                <div class="row col-sm-12 full_width">
                    <div class="row col-sm-6 full_width">
                        <div class="col-sm-3 my-auto" style="font-weight: bold;">{{ trans('label.bill_code') }}</div>
                        <div class="col-sm-9">
                            <input type="text" class="full_width form-control" name="bill_code" id="bill_code" value="{{ old('bill_code', $parcel->bill_code) }}">
                            @if ($errors->has('bill_code'))
                            <p class="common_form_error">
                                {{ $errors->first('bill_code') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="row col-sm-6 full_width">
                        <div class="col-sm-4 my-auto" style="font-weight: bold;">{{ trans('label.parcel_code') }}</div>
                        <div class="col-sm-8">
                            <input type="text" class="full_width form-control" name="parcel_code" id="parcel_code" value="{{ $parcel->parcel_code }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- left -->
                    <div class="col-sm-6 left">
                        <p class="file_form_top_title">{{ trans('label.guest_info') }}</p>
                        <div class="row">
                            <div class="col-sm-2 my-auto">{{ trans('label.guest_code') }}</div>
                            <div class="col-sm-10 my-auto">
                                @php
                                    $guest_invalid = $errors->has('guest_id') ? ' is-invalid' : '';
                                @endphp
                                <select id="guest_id" name="guest_id" class="form-control form-control{{ $guest_invalid }}">
                                    <option value="">Chọn mã khách hàng</option>
                                    @if(!empty($guests))
                                    @foreach ($guests as $guest)
                                        @php
                                            $selected_guest = '';
                                            if (old('guest_id', data_get($parcel, 'guest_id', -999)) == data_get($guest, 'id')) {
                                                $selected_guest = ' selected="selected"';
                                            }
                                        @endphp
                                        <option value="{{ data_get($guest, 'id') }}"
                                            data-code="{{ data_get($guest, 'guest_code') }}"
                                            data-company_name="{{ data_get($guest, 'company_name') }}"
                                            data-province="{{ data_get($guest, 'provincial') }}"
                                            data-district="{{ data_get($guest, 'district') }}"
                                            data-ward="{{ data_get($guest, 'ward') }}"
                                            data-address="{{ data_get($guest, 'address') }}"
                                            data-province_name="{{ data_get($guest, 'province_name') }}"
                                            data-district_name="{{ data_get($guest, 'district_name') }}"
                                            data-ward_name="{{ data_get($guest, 'ward_name') }}"
                                        {{$selected_guest}}>{{ data_get($guest, 'company_name').'('.data_get($guest, 'guest_code').')' }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="guest_code" id="guest_code">
                                @if ($errors->has('guest_id'))
                                <p class="common_form_error">
                                    {{ $errors->first('guest_id') }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">{{ trans('label.company_name') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea disabled class="form-control" id="company_name"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">{{ trans('label.provincial') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <textarea disabled class="form-control" id="company_province"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">{{ trans('label.district') }}</div>
                            <div class="col-sm-6">{{ trans('label.ward') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <textarea disabled class="form-control" id="company_district"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <textarea disabled class="form-control" id="company_ward"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">{{ trans('label.address') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea disabled class="form-control" id="company_address"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- right -->
                    <div class="col-sm-6 right">
                        <p class="file_form_top_title">{{ trans('label.receiver_info') }}</p>
                        <div class="row">
                            <div class="col-sm-6 my-auto">{{ trans('label.delivery_to_company_name') }}</div>
                            <div class="col-sm-6 my-auto">{{ trans('label.full_name') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 my-auto">
                                <input type="text" class="full_width form-control" name="receiver_company" value="{{ old('receiver_company', $parcel->receiver_company) }}">
                            </div>
                            <div class="col-sm-6 my-auto">
                                @php
                                    $receiver_invalid = $errors->has('receiver') ? ' is-invalid' : '';
                                @endphp
                                <input type="text" class="full_width form-control{{ $receiver_invalid }}" name="receiver" value="{{ old('receiver', $parcel->receiver) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 my-auto">{{ trans('label.provincial') }}</div>
                            <div class="col-sm-6 my-auto">{{ trans('label.tel') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 my-auto" id="div_provinces">
                                @php
                                    $province_invalid = $errors->has('province') ? ' is-invalid' : '';
                                @endphp
                                <select id="province" class="full_width form-control{{ $province_invalid }}" name="province">
                                    <option value="">{{ trans('label.please_choose') }}</option>
                                    @if(!empty($provincials))
                                    @foreach ($provincials as $code => $info)
                                        @php
                                            $check = '';
                                            if (old('province', data_get($parcel, 'provincial', -999)) == $code) {
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
                                <input type="text" class="full_width form-control{{ $receiver_tel_invalid }}" name="receiver_tel" value="{{ old('receiver_tel', data_get($parcel, 'receiver_tel')) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 my-auto">{{ trans('label.district') }}</div>
                            <div class="col-sm-6 my-auto">{{ trans('label.ward') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 my-auto" id="div_districts">
                                @php
                                    $district_invalid = $errors->has('district') ? ' is-invalid' : '';
                                @endphp
                                <select name="district" class="full_width form-control{{ $district_invalid }}" id="district">
                                    <option value="">{{ trans('label.please_choose') }}</option>
                                    @if(!empty($districts))
                                    @foreach ($districts as $code => $district)
                                        @php
                                            $districted = '';
                                            if (old('district', data_get($parcel, 'district', -999)) == $code) {
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
                                <select name="ward" class="full_width form-control{{ $ward_invalid }}" id="ward">
                                    <option value="">{{ trans('label.please_choose') }}</option>
                                    @if(!empty($wards))
                                    @foreach ($wards as $code => $ward)
                                        @php
                                            $ward_checked = '';
                                            if (old('ward', data_get($parcel, 'ward', -999)) == $code) {
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
                        <div class="row">
                            <div class="col-sm-6 my-auto">{{ trans('label.address') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 my-auto" id="div_address">
                                @php
                                    $add_invalid = $errors->has('address') ? ' is-invalid' : '';
                                @endphp
                                <input type="text" class="full_width form-control{{ $add_invalid }}" name="address" id="address" value="{{ old('address', data_get($parcel, 'address')) }}">
                                @if ($errors->has('address'))
                                <p class="common_form_error">
                                    {{ $errors->first('address') }}
                                </p>
                                @endif
                            </div>
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
                                                if (old('type', data_get($parcel, 'type')) == $type_id) {
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
                                        value="{{ old('weight', data_get($parcel, 'weight', '0.100')) }}" class="full_width form-control{{ $weight_invalid }}" id="weight" />
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
                                        value="{{ old('real_weight', data_get($parcel, 'real_weight', '0.100')) }}"
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
                                        value="{{ old('long', data_get($parcel, 'long', '0.00')) }}" id="long" />
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
                                        value="{{ old('wide', data_get($parcel, 'wide', '0.00')) }}" id="wide" />
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
                                    <input type="text" name="height" value="{{ old('height', data_get($parcel, 'height', '0.00')) }}"
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
                                <div class="col-sm-5 my-auto">{{ trans('label.num_package') }}</div>
                                <div class="col-sm-7 my-auto">
                                    @php
                                        $num_invalid = $errors->has('num_package') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="number" name="num_package" value="{{ old('num_package', data_get($parcel, 'num_package', '1')) }}" class="full_width form-control{{ $num_invalid }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4 my-auto">{{ trans('label.value_declare') }}</div>
                                <div class="col-sm-8 my-auto">
                                    <input type="number" id="value_declare" name="value_declare" value="{{ old('value_declare', $parcel->value_declare) }}" class="full_width form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row col-sm-12">
                    <p class="file_form_top_title">{{ trans('label.service_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-5">
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
                                                if (old('type_transfer', data_get($parcel, 'type_transfer')) == $id) {
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
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-5 my-auto">{{ trans('label.time_receive') }}</div>
                                <div class="col-sm-7 my-auto">
                                    @php
                                        $time_receive_invalid = $errors->has('time_receive') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" name="time_receive" value="{{ old('time_receive', data_get($parcel, 'time_receive')) }}" class="full_width datepicker form-control{{ $time_receive_invalid }}">
                                    @if ($errors->has('time_receive'))
                                    <p class="common_form_error">
                                        {{ $errors->first('time_receive') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-sm-5 my-auto">{{ trans('label.services') }}</div>
                                <div class="col-sm-7 my-auto">
                                    @php
                                        $services_invalid = $errors->has('services') ? ' is-invalid' : '';
                                        $service_names = '';
                                        if(!empty($services_display)) {
                                            //services explode to element
                                            $old_services = stringify2array(old('services'));
                                            $checked_services = array_pluck($old_services, 'key') ?: [];
                                            $service_names = array_pluck($old_services, 'name') ?: [];
                                            $service_names = implode(', ', $service_names);
                                        }
                                    @endphp
                                    <button type="button" name="service_list" id="service_list" class="full_width form-control{{ $services_invalid }}" data-toggle="modal" data-target="#services_list_model">{{ trans('label.services') }}</button>
                                    <input type="hidden" id="services" name="services" value="{{ old('services') }}">
                                    @if ($errors->has('services'))
                                    <p class="common_form_error">
                                        {{ $errors->first('services') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="row" style="margin: 5px 0;">
                                <div class="col-sm-5" style="padding: 0;">{{ trans('label.total_service') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 my-auto">
                                    <input type="text" name="total_service" id="total_service" class="form-control" value="{{ old('total_service', data_get($parcel, 'total_service')) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="col-sm-12">
                                <textarea class="form-control" id="services_display" name="services_display" disabled>{{ $service_names }}</textarea>
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
                                    <input type="text" id="price" name="price" class="form-control{{ $price_invalid }}" value="{{ old('price', data_get($parcel, 'price')) }}">
                                </td>
                                <td class="title my-auto">{{ trans('label.cod') }}</td>
                                <td>
                                    <input type="text" id="cod" name="cod" class="form-control" value="{{ old('cod', data_get($parcel, 'cod')) }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="title my-auto">{{ trans('label.refund') }}</td>
                                <td>
                                    <input type="text" id="refund" name="refund" class="form-control" value="{{ old('refund', data_get($parcel, 'refund')) }}">
                                </td>
                                <td class="title my-auto">{{ trans('label.support_remote') }}</td>
                                <td class="rate_value">
                                    @php
                                        $remote_rate_invalid = $errors->has('support_remote_rate') ? ' is-invalid' : '';
                                        $remote_invalid = $errors->has('support_remote') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" class="form-control{{ $remote_rate_invalid }}" id="support_remote_rate" name="support_remote_rate" value="{{ data_get($default, 'support_remote') }}"> % <input type="text" class="form-control{{ $remote_invalid }}" id="support_remote" name="support_remote" value="{{ old('support_remote', data_get($parcel, 'support_remote')) }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="title my-auto">{{ trans('label.forward') }}</td>
                                <td>
                                    <input type="text" id="forward" class="form-control" name="forward" value="{{ old('forward', data_get($parcel, 'forward')) }}">
                                </td>
                                <td class="title my-auto">{{ trans('label.support_gas') }}</td>
                                <td class="rate_value">
                                    @php
                                        $gas_rate_invalid = $errors->has('support_gas_rate') ? ' is-invalid' : '';
                                        $gas_invalid = $errors->has('support_gas') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" class="form-control{{ $gas_rate_invalid }}" id="support_gas_rate" name="support_gas_rate" value="{{ data_get($default, 'support_gas') }}"> % <input type="text" class="form-control{{ $gas_invalid }}" id="support_gas" name="support_gas" value="{{ old('support_gas', data_get($parcel, 'support_gas')) }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="title my-auto">{{ trans('label.vat') }}</td>
                                <td class="rate_value">
                                    @php
                                        $vat_rate_invalid = $errors->has('vat') ? ' is-invalid' : '';
                                        $vat_invalid = $errors->has('price_vat') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" id="vat" name="vat" class="form-control{{ $vat_rate_invalid }}" value="{{ data_get($default, 'vat') }}"> % <input type="text" name="price_vat" id="price_vat" class="form-control{{ $vat_invalid }}" value="{{ old('price_vat', data_get($parcel, 'price_vat')) }}">
                                </td>
                                <td class="title bold my-auto">{{ trans('label.total') }}</td>
                                <td>
                                    @php
                                        $total_invalid = $errors->has('total') ? ' is-invalid' : '';
                                    @endphp
                                    <input type="text" id="total" class="form-control{{ $total_invalid }}" name="total" value="{{ old('total', data_get($parcel, 'total')) }}">
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
                            <textarea class="form-control" id="note" name="note">{{ old('note', data_get($parcel, 'note')) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- button action -->
                <div class="form_btn_area center">
                    <button class="btn btn-primary" id="create_parcel" type="button">{{ trans('label.edit') }}</button>
                </div>
                <div style="display:none;">
                    <input type="hidden" id="url_get_price" value="{{ route('ajax.calculate.price') }}">
                    <input type="hidden" name="cal_remote" id="cal_remote" value="{{ old('cal_remote', $cal_remote) }}">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="services_list_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('label.services_model') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" style="width: 100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>{{ trans('label.service_name') }}</th>
                            <th>{{ trans('label.price') }}</th>
                            <th>{{ trans('label.note') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($services_display))
                        @php
                            //services explode to element
                            $old_services = stringify2array(old('services', data_get($parcel, 'services')));
                            $checked_services = array_pluck($old_services, 'key') ?: [];
                            $service_names = array_pluck($old_services, 'name') ?: [];
                            $service_names = implode(', ', $service_names);
                        @endphp
                        @foreach($services_display as $s)
                        @php
                            $tr_class = '';
                            $checkbox = '';
                            if(in_array($s['key'], $checked_services)) {
                                $tr_class = ' table-success';
                                $checkbox = 'checked="checked"';
                            }
                        @endphp
                        <tr class="service_id_choose{{ $tr_class }}">
                            <td>
                                <input type="checkbox" name="service_id[]"
                                {{ $checkbox }}
                                data-key="{{ $s['key'] }}"
                                @if(!empty($s['atleast']))
                                data-atleast="{{ $s['atleast'] }}"
                                @endif
                                @if(!empty($s['limit']))
                                data-limit="{{ $s['limit'] }}"
                                @endif
                                @if(!empty($s['price']))
                                data-price_range="{{ $s['price'] }}"
                                @endif
                                data-name="{{ $s['name'] }}"
                                data-math="{{ data_get($s, 'math', '+') }}"
                                value="{{ $s['value'] }}">
                            </td>
                            <td>{{ $s['name'] }}</td>
                            <td>{{ $s['display'] }}</td>
                            <td>{{ $s['note'] }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4">{{ trans('message.empty_service') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('label.close') }}</button>
                <button class="btn btn-primary" id="add_services" type="submit">{{ trans('label.save') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/admin/parcel.js') }}"></script>
<script src="{{ asset('js/address.js') }}"></script>
@endsection
