@php
    $table  = empty($export) ? 'page_table table table-bordered full_width scroll-table' : '';
    $border = !empty($export) ? 'border: 1px solid black;' : '';
    $thead  = !empty($export) ? 'font-weight: bold;border: 1px solid black;' : '';
@endphp
@if(!empty($export))
<table id="tbl_header">
    <tbody>
        <tr>
            <td width="40"><img style="width: 1px;" src="{{ public_path('images/logo_both.png') }}"></td>
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
            <td>{{ trans('label.page_name') }}</td>
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
            <td>&nbsp;</td>
            <td style="font-weight: bold;">{{ trans('label.guest_name') }}</td>
            <td colspan="7" style="text-align: left;">{{ data_get($guest, 'company_name') }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style="font-weight: bold;">{{ trans('label.guest_code') }}</td>
            <td colspan="7" style="text-align: left;">{{ data_get($guest, 'guest_code') }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style="font-weight: bold;">{{ trans('label.address') }}</td>
            <td colspan="7" style="text-align: left;">{{ data_get($guest, 'address') }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style="font-weight: bold;">{{ trans('label.total_parcels') }}</td>
            <td colspan="7" style="text-align: left;">{{ count($parcels) }}</td>
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
        <th style="{{ $thead }}">{{ trans('label.note') }}</th>
    </tr>
    </thead>
    @if($parcels)
    <tbody>
    @foreach ($parcels as $k => $parcel)
    <tr>
        <td style="{{ $border }}" class="{{ $parcel->id }}">{{ $k + 1 }}</td>
        <td data-format="0" style="{{ $border }}">{{ $parcel->bill_code }}</td>
        <td style="{{ $border }}">{{ $parcel->receiveDate }}</td>
        <td style="{{ $border }}">{{ $parcel->transferName }}</td>
        <td style="{{ $border }}">{{ $parcel->provinceName }}</td>
        <td style="{{ $border }}">{{ $parcel->weight }}</td>
        <td data-format="0,0.00" style="{{ $border }}">{{ !empty($export) ? removeFormatPrice($parcel->price) : $parcel->price }}</td>
        <td data-format="0,0.00" style="{{ $border }}">{{ !empty($export) ? removeFormatPrice($parcel->forwardAndRefund()) : $parcel->forwardAndRefund() }}</td>
        <td data-format="0,0.00" style="{{ $border }}">{{ !empty($export) ? removeFormatPrice($parcel->totalServicePrice()) : $parcel->totalServicePrice() }}</td>
        <td data-format="0,0.00" style="{{ $border }}">{{ !empty($export) ? removeFormatPrice($parcel->remoteAndOther()) : $parcel->remoteAndOther() }}</td>
        <td data-format="0,0.00" style="{{ $border }}">{{ !empty($export) ? removeFormatPrice($parcel->gasAndVat()) : $parcel->gasAndVat() }}</td>
        <td data-format="0,0.00" style="{{ $border }}">{{ !empty($export) ? removeFormatPrice($parcel->total) : $parcel->total }}</td>
        <td style="{{ $border }}">{{ $parcel->note }}</td>
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
        <td data-format="0,0.00" style="{{ $border }}">{{ !empty($export) ? removeFormatPrice($amount) : $amount }}</td>
    </tr>
    </tbody>
    @endif
</table>