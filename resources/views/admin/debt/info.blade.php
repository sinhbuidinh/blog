<div class="tbl-content col-sm-12 table-responsive">
    <table class="page_table table table-bordered full_width" id="parcels_tbl">
        <thead>
            <tr>
                <th class="table_title parcel_code">{{ trans('label.parcel_code') }}</th>
                <th class="table_title">{{ trans('label.status') }}</th>
                <th class="table_title parcel_code">{{ trans('label.bill_code') }}</th>
                <th class="table_title">{{ trans('label.guest_code') }}</th>
                <th class="table_title">{{ trans('label.type_transfer') }}</th>
                <th class="table_title">{{ trans('label.time_get') }}</th>
                <th class="table_title">{{ trans('label.parcel_type') }}</th>
                <th class="table_title">{{ trans('label.agency') }}</th>
                <th class="table_title">{{ trans('label.address') }}</th>
                <th class="table_title">{{ trans('label.total') }}</th>
                <th class="table_title">{{ trans('label.note') }}</th>
                <th class="table_title small">{{ trans('label.edit') }}</th>
                <th class="table_title small">{{ trans('label.delete') }}</th>
            </tr>
        </thead>
        @if($parcels)
        <tbody>
        @foreach ($parcels as $parcel)
        <tr>
            <td class="table_text parcel_code">
                <a class="inline" href="{{ route('parcel.edit', $parcel->id) }}">{{ $parcel->parcel_code }}</a>
            </td>
            <td class="table_text">
                <p class="status_label">{{ $parcel->statusName }}</p>
            </td>
            <td class="table_text parcel_code">{{ $parcel->bill_code }}</td>
            <td class="table_text">{{ $parcel->guest_code }}</td>
            <td class="table_text">{{ $parcel->transferName }}</td>
            <td class="table_text">{{ $parcel->time_receive }}</td>
            <td class="table_text">{{ $parcel->typeName }}</td>
            <td class="table_text">{{ $parcel->agencyName }}</td>
            <td class="table_text">{{ $parcel->address }}</td>
            <td class="table_text">{{ $parcel->total }}</td>
            <td class="table_text">{{ $parcel->note }}</td>
            <td class="table_text small">
                <a href="{{ route('parcel.edit', $parcel->id) }}">
                    <img src="{{ asset('images/edit.png?v=1.0.1') }}">
                </a>
            </td>
            <td class="table_text small">
                <a href="{{ route('parcel.delete', $parcel->id) }}">
                    <img src="{{ asset('images/delete.png?v=1.0.1') }}">
                </a>
            </td>
        </tr>
        @endforeach
        </tbody>
        @endif
    </table>
</div>