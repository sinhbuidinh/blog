@php
    $table = empty($export) ? 'page_table table table-bordered full_width scroll-table' : '';
    $bold = 'font-weight:bold;';
    $border = !empty($export) ? 'border: 1px solid black;' : '';
    $thead = !empty($export) ? $bold.'border: 1px solid black;' : '';
    $row = 0;
    $stt = 1;
@endphp
<table class="{{ $table }}" id="tbl_header">
    <tbody>
        <tr>
            <td>
                @if(empty($export))
                <img style="width: 100%;" src="{{ asset('images/logo.png') }}">
                @else
                <img style="width: 1px;" src="{{ public_path('images/logo.png') }}">
                @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="10" style="text-align: center;font-weight: bold;">BẢNG KÊ BƯU PHẨM KN 247Express</td>
        </tr>
        <tr>
            <td style="{{ $bold }}">{{ trans('label.from') }}</td>
            <td colspan="4">{{ data_get($package, 'from') }}</td>
            <td style="{{ $bold }}">{{ trans('label.to') }}</td>
            <td colspan="4">{{ data_get($package, 'agencyName') }}</td>
        </tr>
        <tr>
            <td style="{{ $bold }}">{{ trans('label.note') }}</td>
            <td colspan="5">{{ data_get($package, 'note') }}</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="10" style="text-align: center;{{ $bold }}">CÁC BƯU PHẨM GỬI ĐI</td>
        </tr>
        <tr>
            <td style="{{ $bold }}">{{ trans('label.stt') }}</td>
            <td style="{{ $bold }}">{{ trans('label.bill_code') }}</td>
            <td style="{{ $bold }}">{{ trans('label.weight') }}</td>
            <td style="{{ $bold }}">{{ trans('label.destination') }}</td>
            <td style="{{ $bold }}">{{ trans('label.note') }}</td>
            <td style="{{ $bold }}">{{ trans('label.stt') }}</td>
            <td style="{{ $bold }}">{{ trans('label.bill_code') }}</td>
            <td style="{{ $bold }}">{{ trans('label.weight') }}</td>
            <td style="{{ $bold }}">{{ trans('label.destination') }}</td>
            <td style="{{ $bold }}">{{ trans('label.note') }}</td>
        </tr>
        @foreach($parcels as $parcel)
            @if($row%2 == 0)
                <tr>
            @endif
                <td>{{ $stt }}</td>
                <td>{{ data_get($parcel, 'bill_code') }}</td>
                <td>{{ data_get($parcel, 'weight') }}</td>
                <td>{{ data_get($parcel, 'parcelsProvinceName') }}</td>
                <td>{{ data_get($parcel, 'note') }}</td>
            @if($row != 0 && ($row % 2) == 0)
                </tr>
            @endif
            @php
                $stt++;
                $row++;
            @endphp
        @endforeach
        @if(count($parcels) % 2 != 0)
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
    </tbody>
</table>