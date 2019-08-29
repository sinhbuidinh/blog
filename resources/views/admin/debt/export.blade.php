@extends('admin.layouts.master')
@section('title'){{ trans('message.parcel_list') }}@endsection
@section('head')
<style type="text/css">
</style>
@endsection
@section('content')
<div class="list_wrapper">
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content col-sm-12">
                <table class="page_table table table-bordered full_width" id="parcels_tbl">
                    <thead>
                        <tr>
                            <th>{{ trans('label.stt') }}</th>
                            <th>{{ trans('label.bill_code') }}</th>
                            <th>{{ trans('label.date_send') }}</th>
                            <th>{{ trans('label.type_transfer') }}</th>
                            <th>{{ trans('label.province_name') }}</th>
                            <th>{{ trans('label.weight') }}</th>
                            <th>{{ trans('label.price') }}</th>
                            <th>{{ trans('label.refund_forward') }}</th>
                            <th>{{ trans('label.total_services') }}</th>
                            <th>{{ trans('label.remote_other') }}</th>
                            <th>{{ trans('label.gas_vat') }}</th>
                            <th>{{ trans('label.total_amount') }}</th>
                        </tr>
                    </thead>
                    @if($parcels)
                    <tbody>
                    @foreach ($parcels as $k => $parcel)
                    <tr>
                        <td>{{ $k + 1 }}</td>
                        <td>{{ $parcel->bill_code }}</td>
                        <td>{{ $parcel->time_receive }}</td>
                        <td>{{ $parcel->type_transfer }}</td>
                        <td>{{ $parcel->provinceName }}</td>
                        <td>{{ $parcel->weight }}</td>
                        <td>{{ $parcel->price }}</td>
                        <td>{{ $parcel->forwardAndRefund }}</td>
                        <td>{{ $parcel->total_service }}</td>
                        <td>{{ $parcel->remoteAndOther }}</td>
                        <td>{{ $parcel->gasAndVat }}</td>
                        <td>{{ $parcel->total }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection