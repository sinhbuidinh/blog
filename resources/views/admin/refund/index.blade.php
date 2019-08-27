@extends('admin.layouts.master')
@section('head')
<style type="text/css">
    #refunds_tbl thead th:not(.small) {
        width: 150px;
    }
    th.parcel_code, td.parcel_code {
        width: 180px !important;
    }
    .page_list_block .table_text:not(.small) a {
        display: unset;
    }
    #keyword {
        width: 245px
    }
    .list_search.list_search_with_button input,
    .list_search.list_search_with_button select {
        padding: 0 0 0 10px;
    }
    .list_search.list_search_with_button div[class^="col-sm"] {
        padding: 0 0 0 10px;
    }
</style>
@endsection
@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">Danh sách {{ trans('label.refund') }}</h1>
        <div id="group_create">
            <a href="{{ route('refund.input') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('refund')}}" method="get">
            <div class="list_search list_search_with_button">
                <div class="row col-sm-12">
                    <div class="col-sm-3">
                        <input type="text" id="keyword" name="keyword" placeholder="{{ trans('label.refund_keyword_holder') }}" value="{{ old('keyword', data_get($search, 'keyword')) }}" autocomplete="off" />
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" name="guest_id" id="guest_id">
                            @php
                                $guest_id = old('guest_id', data_get($search, 'guest_id'));
                            @endphp
                            <option value="">{{ trans('label.please_choose_guest') }}</option>
                            @if(!empty($guests))
                            @foreach($guests as $guest)
                                @php
                                    $guest_selected = '';
                                    if (data_get($guest, 'id') == $guest_id) {
                                        $guest_selected = 'selected="selected"';
                                    }
                                @endphp
                                <option value="{{ data_get($guest, 'id') }}" {{ $guest_selected }}>{{ data_get($guest, 'company_name') }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="datepicker" id="dates" name="dates" placeholder="{{ trans('label.pick_date') }}" value="{{ old('dates', data_get($search, 'dates')) }}" autocomplete="off" />
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="list_search_submit">
                            <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('admin.layouts.session-message')

    {!! $refunds->links('admin.layouts.pagination-total') !!}
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content table-responsive col-sm-12">
                <table class="page_table table table-bordered full_width" id="refunds_tbl">
                    <thead>
                        <tr>
                            <th class="table_title parcel_code">{{ trans('label.parcel_code') }}</th>
                            <th class="table_title">{{ trans('label.bill_code') }}</th>
                            <th class="table_title">{{ trans('label.package_code') }}</th>
                            <th class="table_title">{{ trans('label.guest_code') }}</th>
                            <th class="table_title">{{ trans('label.type_transfer') }}</th>
                            <th class="table_title">{{ trans('label.time_input') }}</th>
                            <th class="table_title">{{ trans('label.parcel_type') }}</th>
                            <th class="table_title">{{ trans('label.address') }}</th>
                            <th class="table_title">{{ trans('label.status') }}</th>
                            <th class="table_title">{{ trans('label.total') }}</th>
                            <th class="table_title">{{ trans('label.note') }}</th>
                        </tr>
                    </thead>
                    @if($refunds)
                    @foreach ($refunds as $parcel)
                    <tbody>
                    <tr>
                        <td class="table_text parcel_code">
                            <a class="inline" href="{{ route('parcel.edit', $parcel->id) }}">{{ $parcel->parcel_code }}</a>
                        </td>
                        <td class="table_text">{{ $parcel->bill_code }}</td>
                        <td class="table_text">{{ $parcel->package_code }}</td>
                        <td class="table_text">{{ $parcel->guest_code }}</td>
                        <td class="table_text">{{ $parcel->transferName }}</td>
                        <td class="table_text">{{ $parcel->time_receive }}</td>
                        <td class="table_text">{{ $parcel->typeName }}</td>
                        <td class="table_text">{{ $parcel->address }}</td>
                        <td class="table_text">
                            <p class="status_label">{{ $parcel->statusName }}</p>
                        </td>
                        <td class="table_text">{{ $parcel->total }}</td>
                        <td class="table_text">{{ $parcel->note }}</td>
                    </tr>
                    </tbody>
                    @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="common_pager">{!! $refunds->links('pagination::bootstrap-4') !!}</div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $('input[name="dates"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endsection
