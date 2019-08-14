@extends('admin.layouts.master')
@section('title'){{ trans('message.create_parcel') }}@endsection
@section('head')
<style type="text/css">
    #parcels_tbl th, td {
        min-width: 120px;
    }
</style>
@endsection
@section('content')
<div class="common_main_wrap">
    <div class="list_wrapper">
        <div class="index_top_block">
            <h1 class="common_page_title">Tạo vận đơn</h1>
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
                        <select class="form-control full_width" name="parcel_code" id="parcel_code">
                            <option value="">{{ trans('label.please_choose') }}</option>
                            <option value="xx">xxx</option>
                            <option value="xx">bbb</option>
                            <option value="xx">ccc</option>
                            <option value="xx">ddd</option>
                            <option value="xx">ee</option>
                            <option value="xx">ff</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row col-sm-12">
                    <div class="table-responsive col-sm-12">
                        <table class="table full_width table-bordered" id="parcels_tbl">
                            <thead>
                            <tr>
                                <th scope="col">{{ trans('label.parcel_code') }}</th>
                                <th scope="col">{{ trans('label.bill_code') }}</th>
                                <th scope="col">{{ trans('label.transfer_name') }}</th>
                                <th scope="col">{{ trans('label.parcel_type') }}</th>
                                <th scope="col">{{ trans('label.address') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">{{ trans('label.parcel_code') }}</th>
                                <td>{{ trans('label.bill_code') }}</td>
                                <td>{{ trans('label.transfer_name') }}</td>
                                <td>{{ trans('label.parcel_type') }}</td>
                                <td>{{ trans('label.address') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(function(){
    $("#parcel_code").select2();
});
</script>
@endsection
