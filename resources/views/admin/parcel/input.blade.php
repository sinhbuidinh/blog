@extends('admin.layouts.master')
@section('title'){{ trans('message.create_parcel') }}@endsection
@section('head')
<style type="text/css">
    input, select {
        padding: 0 10px;
    }
    #price_info tr td.title {
        width: 100px;
    }
    #price_info tr td.bold {
        font-weight: bold;
    }
    #price_info td.rate_value input:first-child {
        width: 80px;
    }
    .left .row,
    .right .row {
        margin: 5px;
    }
</style>
@endsection

@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">Tạo bưu phẩm</h1>
        </div>
        @if(Session::has('flashError'))
        <div class="form_box">
            <p class="alert">{{ Session::get('flashError') }}</p>
        </div>
        @endif
        <div class="file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('parcel.create') }}" id="parcel_form" method="post">
                <div class="hidden">
                    {{ csrf_field() }}
                    <input type="hidden" id="tax_value" value="10" />
                </div>
                <div class="row">
                    <!-- left -->
                    <div class="col-sm-6 left">
                        <p class="file_form_top_title">{{ trans('label.guest_info') }}</p>
                        <div class="row">
                            <div class="col-sm-4">{{ trans('label.guest_name') }}</div>
                            <div class="col-sm-8">
                                <select id="guest_id" name="guest_id">
                                    <option value="">Chọn mã khách hàng</option>
                                    @if(!empty($guests))
                                    @foreach ($guests as $guest_id => $guest_name)
                                        @php
                                            $selected_guest = '';
                                            if (old('guest_id', -999) == $guest_id) {
                                                $selected_guest = ' selected="selected"';
                                            }
                                        @endphp
                                        <option value="{{ $client_id }}" {{$selected_guest}}>{{ $guest_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('guest_id'))
                                <p class="common_form_error">
                                    {{ $errors->first('guest_id') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- right -->
                    <div class="col-sm-6 right">
                        <p class="file_form_top_title">{{ trans('label.receiver_info') }}</p>
                        <div class="row">
                            <div class="col-sm-3">{{ trans('label.full_name') }}</div>
                            <div class="col-sm-5">
                                <input type="text" class="full_width" name="receiver" value="{{ old('receiver') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">{{ trans('label.tel') }}</div>
                            <div class="col-sm-5">
                                <input type="text" class="full_width" name="receiver_tel" value="{{ old('receiver_tel') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">{{ trans('label.provincial') }}</div>
                            <div class="col-sm-5">
                                <select id="province" class="full_width" name="province">
                                    <option value="">{{ trans('label.please_choose') }}</option>
                                    @if(!empty($provincials))
                                    @foreach ($provincials as $code => $info)
                                        @php
                                            $check = '';
                                            if (old('province', -999) == data_get($info, 'code')) {
                                                $check = ' selected="selected"';
                                            }
                                        @endphp
                                        <option value="{{ data_get($info, 'code') }}" 
                                        data-districts="{{ route('district.by.province', data_get($info, 'code')) }}"
                                        {{ $check }}>{{ data_get($info, 'name') }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">{{ trans('label.district') }}</div>
                            <div class="col-sm-5" id="div_districts">
                                <select name="district" class="full_width" id="district">
                                    <option>{{ trans('label.please_choose') }}</option>
                                    @if(!empty($districts))
                                    @foreach ($districts as $id => $name)
                                        @php
                                            $districted = '';
                                            if (old('district', -999) == $id) {
                                                $districted = ' selected="selected"';
                                            }
                                        @endphp
                                        <option value="{{ $id }}" {{$districted}}>{{ $name }}</option>
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
                        <div class="row">
                            <div class="col-sm-3">{{ trans('label.ward') }}</div>
                            <div class="col-sm-5" id="div_wards">
                                <select name="ward" class="full_width" id="ward">
                                    <option>{{ trans('label.please_choose') }}</option>
                                    @if(!empty($wards))
                                    @foreach ($wards as $id => $name)
                                        @php
                                            $ward_checked = '';
                                            if (old('ward', -999) == $id) {
                                                $ward_checked = ' selected="selected"';
                                            }
                                        @endphp
                                        <option value="{{ $id }}" {{$ward_checked}}>{{ $name }}</option>
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
                    </div>
                </div>

                <!-- package info -->
                <div class="row col-sm-12">
                    <p class="file_form_top_title">{{ trans('label.parcel_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-5">{{ trans('label.parcel_type') }}</div>
                                <div class="col-sm-7">
                                    <select name="type" class="full_width" id="parcel_type">
                                        <option>{{ trans('label.please_choose') }}</option>
                                        @if(!empty($parcel_types))
                                        @foreach ($parcel_types as $type_id => $type_name)
                                            @php
                                                $parcel_check = '';
                                                if (old('type', -999) == $type_id) {
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
                                <div class="col-sm-4">{{ trans('label.weight') }}</div>
                                <div class="col-sm-8">
                                    <input type="text" name="weight" 
                                        value="{{ old('weight') }}" class="full_width" id="weight" />
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
                                <div class="col-sm-4">{{ trans('label.real_weight') }}</div>
                                <div class="col-sm-8">
                                    <input type="text" name="real_weight" 
                                        value="{{ old('real_weight') }}"
                                        id="real_weight" class="full_width" />
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
                                <div class="col-sm-5">{{ trans('label.long') }}</div>
                                <div class="col-sm-7">
                                    <input type="text" name="long" class="full_width"
                                        value="{{ old('long') }}" id="long" />
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
                                <div class="col-sm-4">{{ trans('label.wide') }}</div>
                                <div class="col-sm-8">
                                    <input type="text" name="wide" class="full_width"
                                        value="{{ old('wide') }}" id="wide" />
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
                                <div class="col-sm-4">{{ trans('label.height') }}</div>
                                <div class="col-sm-8">
                                    <input type="text" name="height" value="{{ old('height') }}"
                                        id="height" class="full_width" />
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
                                <div class="col-sm-5">{{ trans('label.num_package') }}</div>
                                <div class="col-sm-7">
                                    <input type="number" name="num_package" value="{{ old('num_package') }}" class="full_width">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row col-sm-12">
                    <p class="file_form_top_title">{{ trans('label.service_info') }}</p>
                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-5">{{ trans('label.type_transfer') }}</div>
                                <div class="col-sm-7">
                                    <select name="type_transfer" class="full_width" id="service_type">
                                        <option>{{ trans('label.please_choose') }}</option>
                                        @if(!empty($type_transfer))
                                        @foreach ($type_transfer as $id => $name)
                                            @php
                                                $transfer_check = '';
                                                if (old('type_transfer', -999) == $id) {
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
                                <div class="col-sm-5">{{ trans('label.time_input') }}</div>
                                <div class="col-sm-7">
                                    <input type="text" name="time_input" value="{{ old('time_input', now()->format('d-m-Y')) }}" class="full_width datepicker" data-date-format="dd-mm-yyyy">
                                    @if ($errors->has('time_input'))
                                    <p class="common_form_error">
                                        {{ $errors->first('time_input') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-5">{{ trans('label.services') }}</div>
                                <div class="col-sm-7">
                                    <button type="button" name="service_list" id="service_list" class="full_width" data-toggle="modal" data-target="#services_list_model">{{ trans('label.services') }}</button>
                                    <input type="hidden" name="services" value="{{ old('services') }}">
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
                                <td class="title">{{ trans('label.price') }}</td>
                                <td><input type="number" name="price" value="{{ old('price') }}"></td>
                                <td class="title">{{ trans('label.cod') }}</td>
                                <td><input type="text" name="cod" value="{{ old('cod') }}"></td>
                            </tr>
                            <tr>
                                <td class="title">{{ trans('label.refund') }}</td>
                                <td>
                                    <input type="text" name="cod" value="{{ old('refund') }}">
                                </td>
                                <td class="title">{{ trans('label.support_gas') }}</td>
                                <td class="rate_value">
                                    <input type="number" name="support_gas_rate" value="{{ data_get($default, 'support_gas') }}"> % 
                                    <input type="text" name="support_gas" value="{{ old('support_gas') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="title">{{ trans('label.forward') }}</td>
                                <td>
                                    <input type="text" name="cod" value="{{ old('forward') }}">
                                </td>
                                <td class="title">{{ trans('label.support_remote') }}</td>
                                <td class="rate_value">
                                    <input type="number" name="support_remote_rate" value="{{ data_get($default, 'support_remote') }}"> % 
                                    <input type="text" name="support_remote" value="{{ old('support_remote') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="title">{{ trans('label.vat') }}</td>
                                <td class="rate_value">
                                    <input type="number" name="vat" value="{{ data_get($default, 'vat') }}">
                                    <input type="text" name="price_vat" value="{{ old('price_vat') }}">
                                </td>
                                <td class="title bold">{{ trans('label.total') }}</td>
                                <td>
                                    <input type="text" name="total" value="{{ old('total') }}">
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

                <!-- button action -->
                <div class="form_btn_area center">
                    <a href="{{ route('parcel') }}" class="form_btn_back">Back</a>
                    <input type="submit" class="form_btn_save" 
                        onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();"
                        value="{{ trans('label.create') }}">
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
                        @if (!empty($services_display))
                        @foreach($services_display as $s)
                        <tr class="service_id_choose">
                            <td>
                                <input type="checkbox" name="service_id[]" 
                                data-name="{{ $s['key'] }}"
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
                <button type="button" id="add_services" class="btn btn-primary">{{ trans('label.save') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function(){
        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-0d'
        });
    });
    $(document).on('change', '#province', function(){
        var obj = $(this);
        var url = obj.find(":selected").data('districts');
        if (typeof url == 'undefined') {
            return false;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: {},
            dataType: 'json',
            success: function(data){
                genDistricts(data);
            },
            error: function(){
                alert('error');
            }
        });
    });
    $(document).on('click', 'tr.service_id_choose', function(){
        var id = $(this).find('input[name="service_id[]"]');
        id.attr('checked', true);
        // console.log(id.data('name') + ' ' + id.val());
    });
    $(document).on('click', '#add_services', function(){
        var inputs = $('tr.service_id_choose input[name="service_id[]"]:checked');
        if (inputs.length <= 0) {
            console.log('not find checked');
            closePopup('#services_list_model');
            return false;
        }
        inputs.each(function(index){
            var ele = $(this);
            //ele.data('name') + ' ' + ele.val()
        });
        closePopup('#services_list_model');
    });
    function closePopup(selector)
    {
        $(selector).find('.modal-header button.close').click();
    }
    function addService()
    {
        //
    }
    function genDistricts(data)
    {
        if (typeof data != 'object' || Object.keys(data).length <= 0) {
            return false;
        }
        var districts = '<select name="district" class="full_width" id="district">';
        districts += optionDistrict("{{ trans('label.please_choose') }}", '', '');
        $.each(data, function(key, value) {
            var name = value.name;
            var code = value.code;
            var url = '/ajax/get_wards/' + code;
            districts += optionDistrict(name, code, url);
        });
        districts += '</select>';
        $('#district').remove();
        $('#div_districts').append(districts);
    }
    function optionDistrict(name, code, url)
    {
        return '<option value="'+code+'" data-wards="'+url+'">'+name+'</option>';
    }
</script>
@endsection
