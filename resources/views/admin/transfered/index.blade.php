@extends('admin.layouts.master')
@section('title'){{ trans('message.parcel_list') }}@endsection
@section('head')
<style type="text/css">
    .page_list_block .table_text:not(.small) a {
        display: unset;
    }
    table#parcels_tbl {
        border-collapse: collapse;
        overflow-x: scroll;
        display: block;
    }
    #parcels_tbl thead {
        background-color: #EFEFEF;
    }
    #parcels_tbl thead,
    #parcels_tbl tbody {
        display: block;
    }
    #parcels_tbl tbody {
        overflow-y: scroll;
        overflow-x: hidden;
        height: 340px;
    }
    #parcels_tbl td:not(.small),
    #parcels_tbl th:not(.small) {
        min-width: 180px;
        height: 25px;
        border: dashed 1px lightblue;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
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
        <h1 class="common_page_title">{{ trans('message.parcel_list') }}</h1>
        <div id="group_create">
            <a href="{{ route('parcel.input') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('transfereds')}}" method="get">
            <div class="list_search list_search_with_button">
                <div class="row col-sm-12">
                    <div class="col-sm-3">
                        <input type="text" id="keyword" name="keyword" placeholder="{{ trans('label.parcel_keyword_holder') }}" value="{{ old('keyword', data_get($search, 'keyword')) }}" autocomplete="off" />
                    </div>
                    <div class="col-sm-2">
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
                        <select class="form-control" name="status" id="status">
                            @php
                                $status = old('status', data_get($search, 'status'));
                            @endphp
                            <option value="">{{ trans('label.please_choose_status') }}</option>
                            @if(!empty($statuses))
                            @foreach($statuses as $id => $name)
                                @php
                                    $status_selected = '';
                                    if ($id == $status) {
                                        $status_selected = 'selected="selected"';
                                    }
                                @endphp
                                <option value="{{ $id }}" {{ $status_selected }}>{{ $name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="datepicker" id="dates" name="dates" placeholder="{{ trans('label.pick_date') }}" value="{{ old('dates', data_get($search, 'dates')) }}" autocomplete="off" />
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="list_search_submit">
                            <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('admin.layouts.session-message')

    {!! $parcels->links('admin.layouts.pagination-total') !!}
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content table-responsive col-sm-12">
                <table class="page_table table table-bordered scroll-table full_width" id="parcels_tbl">
                    <thead>
                        <tr>
                            <th class="table_title parcel_code">{{ trans('label.parcel_code') }}</th>
                            <th class="table_title parcel_code">{{ trans('label.bill_code') }}</th>
                            <th class="table_title parcel_code">{{ trans('label.already_transfer') }}</th>
                            <th class="table_title">{{ trans('label.status') }}</th>
                            <th class="table_title">{{ trans('label.guest_code') }}</th>
                            <th class="table_title">{{ trans('label.type_transfer') }}</th>
                            <th class="table_title">{{ trans('label.time_input') }}</th>
                            <th class="table_title">{{ trans('label.parcel_type') }}</th>
                            <th class="table_title">{{ trans('label.agency') }}</th>
                            <th class="table_title">{{ trans('label.address') }}</th>
                            <th class="table_title">{{ trans('label.total') }}</th>
                            <th class="table_title">{{ trans('label.note') }}</th>
                            <th class="table_title small">{{ trans('label.edit') }}</th>
                            <th class="table_title small">{{ trans('label.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($parcels)
                    @foreach ($parcels as $parcel)
                    <tr>
                        <td class="table_text parcel_code">
                            <a class="inline" href="{{ route('parcel.edit', $parcel->id) }}">{{ $parcel->bill_code }}</a>
                        </td>
                        <td class="table_text parcel_code">
                            <a class="inline" href="{{ route('parcel.edit', $parcel->id) }}">{{ $parcel->parcel_code }}</a>
                        </td>
                        <td class="table_text">
                            @if($parcel->readyComplete)
                            <button type="button" data-url="{{ route('transfer', $parcel->id) }}" class="btn btn-primary confirm_complete">{{ trans('label.already_transfer') }}</button>
                            <button type="button" data-url="{{ route('fail', $parcel->id) }}" class="btn btn-danger fail_transfer">{{ trans('label.fail_transfer') }}</button>
                            @else
                            {!! $parcel->failInfo !!}
                            @endif
                        </td>
                        <td class="table_text">
                            <p class="status_label">{{ $parcel->statusName }}</p>
                        </td>
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
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="common_pager">{!! $parcels->appends($search)->links('pagination::bootstrap-4') !!}</div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $(document).on('click', '.confirm_complete', function(){
            window.location.href = $(this).data('url');
        });
        $(document).on('click', '.fail_transfer', function(){
            window.location.href = $(this).data('url');
        });
        $('table.scroll-table').on('scroll', function() {
            $("#" + this.id + " > *").width($(this).width() + $(this).scrollLeft());
        });
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
