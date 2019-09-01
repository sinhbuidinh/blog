@if(!empty($export))
<table id="tbl_header">
    <tbody>
        <tr>
            <td width="40"><img style="width: 1px;" src="{{ public_path('images/logo.png') }}"></td>
            <td>&nbsp;</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="7" style="text-align: center;font-weight: bold;">BẢNG KÊ NỢ CHI TIẾT</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="7" style="text-align: center;font-weight: bold;">Từ ngày {{ $from }} đến ngày {{ $to }}</td>
        </tr>
    </tbody>
</table>
@endif
<table class="page_table table table-bordered full_width scroll-table" id="parcels_tbl">
    <thead>
        <tr>
            <th>{{ trans('label.stt') }}</th>
            <th>{{ trans('label.parcel_code') }}</th>
            <th>{{ trans('label.date_send') }}</th>
            <th>{{ trans('label.type_transfer') }}</th>
            <th>{{ trans('label.destination') }}</th>
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
    <tr style="border: 1px solid #dee2e6;">
        <td class="{{ $parcel->id }}">{{ $k + 1 }}</td>
        <td>{{ $parcel->bill_code }}</td>
        <td>{{ $parcel->time_receive }}</td>
        <td>{{ $parcel->transferName }}</td>
        <td>{{ $parcel->provinceName }}</td>
        <td>{{ $parcel->weight }}</td>
        <td>{{ $parcel->price }}</td>
        <td>{{ $parcel->forwardAndRefund() }}</td>
        <td>{{ $parcel->totalServicePrice() }}</td>
        <td>{{ $parcel->remoteAndOther() }}</td>
        <td>{{ $parcel->gasAndVat() }}</td>
        <td>{{ $parcel->total }}</td>
    </tr>
    @endforeach
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="font-weight: bold">{{ trans('label.amounts') }}</td>
        <td style="border: 1px solid #dee2e6;">{{ $amount }}</td>
    </tr>
    </tbody>
    @endif
</table>