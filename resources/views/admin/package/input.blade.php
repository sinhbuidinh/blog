@extends('admin.layouts.master')
@section('title'){{ trans('message.create_package') }}@endsection
@section('head')
<style type="text/css">
    #parcels_tbl th, #parcels_tbl td {
        min-width: 120px;
    }
</style>
@endsection
@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">{{ trans('message.create_package') }}</h1>
        </div>
        @include('admin.layouts.session-message')
        <div class="file_form_wrap">
            <form class="login_form skip_alert_changes" action="{{ route('package.create') }}" id="parcel_form" method="post">
                <div class="hidden">
                    {{ csrf_field() }}
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-2 bold-text no-padding my-auto">{{ trans('label.input_parcel_code') }}</div>
                    <div class="col-sm-6 no-padding">
                        <select class="form-control full_width" name="parcel_code" id="parcel_code" multiple="multiple">
                            @if(!empty($parcels))
                            <optgroup label="{{ trans('label.please_choose') }}">
                            @foreach($parcels as $parcel)
                            <option data-code="{{ data_get($parcel, 'parcel_code') }}" 
                            data-id="{{ data_get($parcel, 'id') }}"
                            data-company_name="{{ data_get($parcel, 'companyName') }}"
                            data-receiver_company="{{ data_get($parcel, 'receiver_company') }}"
                            data-bill_code="{{ data_get($parcel, 'bill_code') }}"
                            data-type_transfer="{{ data_get($parcel, 'transferName') }}"
                            data-type="{{ data_get($parcel, 'typeName') }}"
                            data-address="{{ data_get($parcel, 'address') }}"
                            data-status="{{ data_get($parcel, 'statusName') }}"
                            data-note="{{ data_get($parcel, 'note') }}"
                            value="{{ data_get($parcel, 'id') }}">{{ data_get($parcel, 'parcelDisplayForPackage') }}</option>
                            @endforeach
                            </optgroup>
                            @endif
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row col-sm-12">
                    <div class="table-responsive col-sm-12">
                        <p>{{ trans('label.number_parcel') }}: <b id="number_parcel">0</b></p>
                        <table class="table full_width table-bordered" id="parcels_tbl">
                            <thead>
                            <tr>
                                <th scope="col">{{ trans('label.company_name') }}</th>
                                <th scope="col">{{ trans('label.parcel_code') }}</th>
                                <th scope="col">{{ trans('label.delivery_to_company_name') }}</th>
                                <th scope="col">{{ trans('label.address') }}</th>
                                <th scope="col">{{ trans('label.status') }}</th>
                                <th scope="col">{{ trans('label.note') }}</th>
                            </tr>
                            </thead>
                            <tbody id="parcels_body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-2">{{ trans('label.time_receive') }}</div>
                    <div class="col-sm-8">
                        @php
                            $date_time_invalid = $errors->has('date_time') ? ' is-invalid' : '';
                        @endphp
                        <input type="text" name="date_time" value="{{ old('date_time', now()->format('Y-m-d h:m:s')) }}" class="full_width datepicker form-control{{ $date_time_invalid }}">
                    </div>
                </div>
                <div class="row col-sm-12">
                    <div class="col-sm-2">{{ trans('label.note') }}</div>
                    <div class="col-sm-8">
                        <textarea class="form-control full_width" name="note" id="note">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="form_btn_area center">
                    <button class="btn btn-primary" id="close_package" type="button">{{ trans('label.close_package') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<button type="button" id="button_none_parcel" data-toggle="modal" style="display: none;" data-target="#none-parcel-select">{{ trans('label.not_have_parcel') }}</button>
<div class="modal fade" id="none-parcel-select" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert alert-primary">
                <h5 class="modal-title" id="title-parcel-nonselect">{{ trans('label.alert') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert alert-danger" role="alert">{{ trans('label.not_have_parcel') .'. '. trans('label.please_choose_parcel') }}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('label.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/admin/package.js') }}"></script>
<script type="text/javascript">
$(function(){
    $('.datepicker').datepicker({
        todayHighlight: true,
        dateFormat: 'yy-mm-dd',
        startDate: '-0d',
        onSelect: function(datetext) {
            var d = new Date(); // for now
            var h = d.getHours();
            h = (h < 10) ? ("0" + h) : h;
            var m = d.getMinutes();
            m = (m < 10) ? ("0" + m) : m;
            var s = d.getSeconds();
            s = (s < 10) ? ("0" + s) : s;
            datetext = datetext + " " + h + ":" + m + ":" + s;
            $('.datepicker').val(datetext);
        }
    });
});
</script>
@endsection
