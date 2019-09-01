@php
    $border = !empty($export) ? 'border: 1px solid black;' : '';
    $table = !empty($export) ? 'page_table table table-bordered full_width scroll-table' : '';
    $thead = !empty($export) ? 'font-weight: bold;border: 1px solid black;' : '';
@endphp
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
        </tr>
        <tr>
            <td style="font-weight: bold;">{{ trans('label.guest_name') }}</td>
            <td colspan="8" style="text-align: left;">{{ data_get($guest, 'company_name') }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">{{ trans('label.guest_code') }}</td>
            <td colspan="8" style="text-align: left;">{{ data_get($guest, 'guest_code') }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">{{ trans('label.address') }}</td>
            <td colspan="8" style="text-align: left;">{{ data_get($guest, 'address') }}</td>
        </tr>
    </tbody>
</table>
@endif
<table class="{{ $table }}" id="parcels_tbl">
    <thead>
    <tr style="{{ $border }}">
        <th style="{{ $thead }}">{{ trans('label.stt') }}</th>
        <th style="{{ $thead }}">{{ trans('label.parcel_code') }}</th>
        <th style="{{ $thead }}">{{ trans('label.date_send') }}</th>
        <th style="{{ $thead }}">{{ trans('label.type_transfer') }}</th>
        <th style="{{ $thead }}">{{ trans('label.destination') }}</th>
        <th style="{{ $thead }}">{{ trans('label.weight') }}</th>
        <th style="{{ $thead }}">{{ trans('label.price') }}</th>
        <th style="{{ $thead }}">{{ trans('label.refund_forward') }}</th>
        <th style="{{ $thead }}">{{ trans('label.total_services') }}</th>
        <th style="{{ $thead }}">{{ trans('label.remote_other') }}</th>
        <th style="{{ $thead }}">{{ trans('label.gas_vat') }}</th>
        <th style="{{ $thead }}">{{ trans('label.total') }}</th>
    </tr>
    </thead>
    @if($parcels)
    <tbody>
    @foreach ($parcels as $k => $parcel)
    <tr>
        <td style="{{ $border }}" class="{{ $parcel->id }}">{{ $k + 1 }}</td>
        <td style="{{ $border }}">{{ $parcel->bill_code }}</td>
        <td style="{{ $border }}">{{ $parcel->time_receive }}</td>
        <td style="{{ $border }}">{{ $parcel->transferName }}</td>
        <td style="{{ $border }}">{{ $parcel->provinceName }}</td>
        <td style="{{ $border }}">{{ $parcel->weight }}</td>
        <td style="{{ $border }}">{{ $parcel->price }}</td>
        <td style="{{ $border }}">{{ $parcel->forwardAndRefund() }}</td>
        <td style="{{ $border }}">{{ $parcel->totalServicePrice() }}</td>
        <td style="{{ $border }}">{{ $parcel->remoteAndOther() }}</td>
        <td style="{{ $border }}">{{ $parcel->gasAndVat() }}</td>
        <td style="{{ $border }}">{{ $parcel->total }}</td>
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
        <td style="{{ $border }}font-weight: bold">{{ trans('label.amounts') }}</td>
        <td style="{{ $border }}">{{ $amount }}</td>
    </tr>
    </tbody>
    @endif
</table>