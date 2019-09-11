@php
    $border = 'border: 1px solid black;';
    $thead  = 'font-weight: bold;border: 1px solid black;';
@endphp
<table>
    <tbody>
        <tr>
            <td width="40"><img style="width: 1px;" src="{{ public_path('images/logo.png') }}"></td>
            <td>&nbsp;</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="7" style="text-align: center;font-weight: bold;">BẢNG DANH SÁCH VẬN ĐƠN</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{{ trans('label.page_name') }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @if(!empty($from) && !empty($to))
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="7" style="text-align: center;font-weight: bold;">Từ ngày {{ $from }} đến ngày {{ $to }}</td>
        </tr>
        @endif
        @if(count($guest) > 0)
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
        @endif
        <tr>
            <td>&nbsp;</td>
            <td style="font-weight: bold;">{{ trans('label.total_parcels') }}</td>
            <td colspan="7" style="text-align: left;">{{ count($parcels) }}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr style="{{ $border }}">
            <th style="{{ $thead }}">{{ trans('label.stt') }}</th>
            <th style="{{ $thead }}">{{ trans('label.parcel_code') }}</th>
            <th style="{{ $thead }}">{{ trans('label.date_send') }}</th>
            <th style="{{ $thead }}">{{ trans('label.type_transfer') }}</th>
            <th style="{{ $thead }}">{{ trans('label.destination') }}</th>
            <th style="{{ $thead }}">{{ trans('label.begin_receiver') }}</th>
            <th style="{{ $thead }}">{{ trans('label.detail_address') }}</th>
            <th style="{{ $thead }}">{{ trans('label.status') }}</th>
            <th style="{{ $thead }}">{{ trans('label.receiver_info') }}</th>
            <th style="{{ $thead }}">{{ trans('label.weight') }}</th>
            <th style="{{ $thead }}">{{ trans('label.total') }}</th>
            <th style="{{ $thead }}">{{ trans('label.note') }}</th>
        </tr>
    </thead>
    @if($parcels)
    <tbody>
        @foreach ($parcels as $k => $parcel)
        <tr>
            <td style="{{ $border }}" class="{{ $parcel->id }}">{{ $k + 1 }}</td>
            <td data-format="0" style="text-align: right;{{ $border }}">{{ $parcel->bill_code }}</td>
            <td style="{{ $border }}">{{ $parcel->receiveDate }}</td>
            <td style="{{ $border }}">{{ $parcel->transferName }}</td>
            <td style="{{ $border }}">{{ $parcel->provinceName }}</td>
            <td style="{{ $border }}">{!! $parcel->beginReceive !!}</td>
            <td style="{{ $border }}">{{ $parcel->address }}</td>
            <td style="{{ $border }}">{{ $parcel->statusName }}</td>
            <td style="{{ $border }}">{!! $parcel->receiverParcelExport !!}</td>
            <td style="{{ $border }}">{{ $parcel->weight }}</td>
            <td data-format="0,0.00" style="{{ $border }}">{{ removeFormatPrice($parcel->total) }}</td>
            <td style="{{ $border }}">{!! $parcel->failInfo !!}</td>
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
            <td style="font-weight: bold;{{ $border }}">{{ trans('label.amounts') }}</td>
            <td data-format="0,0.00" style="{{ $border }}">{{ removeFormatPrice($amounts) }}</td>
        </tr>
    </tbody>
    @endif
</table>