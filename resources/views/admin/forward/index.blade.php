@extends('admin.layouts.master')
@section('head')
<style type="text/css">
    #forwards_tbl thead th:not(.small) {
        width: 150px;
    }
    th.parcel_code, td.parcel_code {
        width: 180px !important;
    }
    .page_list_block .table_text:not(.small) a {
        display: unset;
    }
</style>
@endsection
@section('content')
<div class="list_wrapper">
    <div class="index_top_block">
        <h1 class="common_page_title">Danh sách {{ trans('label.forward') }}</h1>
        <div id="group_create">
            <a href="{{ route('forward.input') }}"
                class="create_new_btn">Tạo mới</a>
        </div>
    </div>
    <div class="search_form">
        <form action="{{ route('forward')}}" method="get">
            <div class="list_search list_search_with_button">
                <input type="text" id="keyword" name="keyword" placeholder="{{ trans('label.forward_keyword_holder') }}" value="{{ old('keyword', data_get($search, 'keyword')) }}" />
                <button type="submit" class="list_search_submit">
                    <img src="{{ asset('images/search_white.png?v=1.0.1') }}" />
                </button>
            </div>
        </form>
    </div>
    @include('admin.layouts.session-message')

    {!! $forwards->links('admin.layouts.pagination-total') !!}
    <div class="page_list_block">
        <div class="page_table">
            <div class="tbl-content table-responsive col-sm-12">
                <table class="page_table table table-bordered full_width" id="forwards_tbl">
                    <thead>
                        <tr>
                            <th class="table_title parcel_code">{{ trans('label.parcel_code') }}</th>
                            <th class="table_title">{{ trans('label.bill_code') }}</th>
                            <th class="table_title">{{ trans('label.package_code') }}</th>
                            <th class="table_title">{{ trans('label.guest_code') }}</th>
                            <th class="table_title">{{ trans('label.type_transfer') }}</th>
                            <th class="table_title">{{ trans('label.parcel_type') }}</th>
                            <th class="table_title">{{ trans('label.address') }}</th>
                            <th class="table_title">{{ trans('label.status') }}</th>
                            <th class="table_title">{{ trans('label.total') }}</th>
                            <th class="table_title">{{ trans('label.note') }}</th>
                        </tr>
                    </thead>
                    @if($forwards)
                    @foreach ($forwards as $parcel)
                    <tbody>
                    <tr>
                        <td class="table_text parcel_code">
                            <a class="inline" href="{{ route('parcel.edit', $parcel->id) }}">{{ $parcel->parcel_code }}</a>
                        </td>
                        <td class="table_text">{{ $parcel->bill_code }}</td>
                        <td class="table_text">{{ $parcel->package_code }}</td>
                        <td class="table_text">{{ $parcel->guest_code }}</td>
                        <td class="table_text">{{ $parcel->transferName }}</td>
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
    <div class="common_pager">{!! $forwards->links('pagination::bootstrap-4') !!}</div>
</div>
@endsection
